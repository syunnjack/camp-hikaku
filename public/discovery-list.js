(() => {
  'use strict';
  const savedKey = 'camp-hikaku:saved:v1';
  const compareKey = 'camp-hikaku:compare:v1';
  const sanitize = (value, max) => Array.isArray(value) ? [...new Set(value.map(Number).filter(id => Number.isSafeInteger(id) && id > 0))].slice(0, max) : [];
  const read = (storage, key, max) => { try { return sanitize(JSON.parse(window[storage].getItem(key) || '[]'), max); } catch { return []; } };
  const write = (storage, key, ids) => { try { window[storage].setItem(key, JSON.stringify(ids)); return true; } catch { return false; } };
  const status = message => { const el = document.querySelector('#save-status'); if (el) el.textContent = message; };
  let saved = read('localStorage', savedKey, 50);
  let compared = read('sessionStorage', compareKey, 3);
  const listUrl = ids => { const url = new URL('/my-list', location.origin); ids.forEach(id => url.searchParams.append('ids[]', id)); return url; };
  if (document.querySelector('[data-shortlist-page]') && !new URL(location.href).searchParams.has('ids[]') && saved.length) {
    location.replace(listUrl(saved));
    return;
  }
  const renderSaved = () => {
    document.querySelectorAll('[data-save-spot]').forEach(button => {
      const selected = saved.includes(Number(button.dataset.saveSpot));
      button.setAttribute('aria-pressed', String(selected));
      button.textContent = selected ? '♥ 保存済み' : '♡ 行きたい';
    });
    document.querySelectorAll('[data-saved-count]').forEach(el => { el.textContent = saved.length ? `(${saved.length})` : ''; });
  };
  document.querySelectorAll('[data-save-spot]').forEach(button => button.addEventListener('click', () => {
    const id = Number(button.dataset.saveSpot);
    const exists = saved.includes(id);
    if (!exists && saved.length >= 50) { status('保存できるのは50件までです。不要な保存を解除してください。'); return; }
    const next = exists ? saved.filter(item => item !== id) : [...saved, id];
    if (!write('localStorage', savedKey, next)) { status('ブラウザーの保存が利用できません。設定をご確認ください。'); return; }
    saved = next;
    renderSaved();
    status(exists ? '行きたい場所の保存を解除しました。' : '行きたい場所に保存しました。メニューの「行きたい」から見返せます。');
  }));
  const form = document.querySelector('#compare-form');
  const renderCompared = () => {
    form?.querySelectorAll('input[name="ids[]"]').forEach(input => { input.checked = compared.includes(Number(input.value)); });
    const feedback = document.querySelector('#compare-feedback');
    if (feedback) feedback.textContent = `${compared.length} / 3件 選択中（ページを移動しても保持）`;
  };
  form?.querySelectorAll('input[name="ids[]"]').forEach(input => input.addEventListener('change', () => {
    const id = Number(input.value);
    if (input.checked && !compared.includes(id) && compared.length >= 3) { input.checked = false; status('比較は3件までです。選択を解除して入れ替えてください。'); return; }
    compared = input.checked ? sanitize([...compared, id], 3) : compared.filter(item => item !== id);
    if (!write('sessionStorage', compareKey, compared)) status('このページ内では比較できますが、ページを移動すると選択が失われます。');
    renderCompared();
  }));
  document.querySelector('[data-clear-comparison]')?.addEventListener('click', () => { compared = []; write('sessionStorage', compareKey, compared); renderCompared(); });
  form?.addEventListener('submit', event => {
    event.preventDefault();
    if (compared.length < 2) { status('比較する施設を2〜3件選んでください。'); return; }
    const url = new URL(form.action);
    compared.forEach(id => url.searchParams.append('ids[]', id));
    location.assign(url);
  });
  document.querySelector('[data-share-list]')?.addEventListener('click', async () => {
    const supplied = new URL(location.href).searchParams.getAll('ids[]');
    const ids = supplied.length ? sanitize(supplied, 50) : saved;
    if (!ids.length) { status('まず行きたい場所を保存してください。'); return; }
    try { await navigator.clipboard.writeText(listUrl(ids).href); status('リストのリンクをコピーしました。'); }
    catch { status('コピーできませんでした。アドレス欄のURLをコピーしてください。'); }
  });
  window.addEventListener('storage', event => { if (event.key === savedKey) { saved = read('localStorage', savedKey, 50); renderSaved(); } });
  renderSaved();
  renderCompared();
})();
