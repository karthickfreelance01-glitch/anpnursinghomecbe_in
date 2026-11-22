/* ANP Admin – small helpers, no dependencies (Quill is optional) */
(function () {
    'use strict';
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));

    // Confirm before destructive submits
    $$('form[data-confirm]').forEach((f) => f.addEventListener('submit', (e) => {
        if (!confirm(f.dataset.confirm)) e.preventDefault();
    }));

    // Auto-hide success alerts
    $$('[data-autohide]').forEach((el) => setTimeout(() => el.classList.add('is-hiding'), 4500));

    // Image preview
    $$('[data-image-input]').forEach((input) => input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        const drop = input.closest('.img-drop');
        const img = $('[data-preview]', drop);
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.hidden = false;
        drop.classList.add('has-img');
    }));

    // Slug from name (only while slug untouched)
    const src = $('[data-slug-source]'), tgt = $('[data-slug-target]');
    const slugify = (s) => s.toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g, '').replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    if (src && tgt) {
        let touched = tgt.value !== '';
        tgt.addEventListener('input', () => { touched = tgt.value !== ''; updateSerp(); });
        src.addEventListener('input', () => { if (!touched) tgt.placeholder = slugify(src.value) || 'auto from name'; updateSerp(); });
    }

    // Icon picker
    const iconInput = $('[data-icon-input]'), iconPrev = $('[data-icon-preview]');
    const setIcon = (v) => { if (iconPrev) iconPrev.className = 'bi ' + (v || 'bi-heart-pulse'); };
    iconInput && iconInput.addEventListener('input', () => setIcon(iconInput.value.trim()));
    $$('[data-icon]').forEach((b) => b.addEventListener('click', () => { iconInput.value = b.dataset.icon; setIcon(b.dataset.icon); }));

    // FAQ repeater
    const faqs = $('[data-faqs]');
    const reindex = () => $$('.faq', faqs).forEach((row, i) => $$('input, textarea', row).forEach((el) => {
        el.name = el.name.replace(/faqs\[\d+\]/, 'faqs[' + i + ']');
    }));
    if (faqs) {
        $('[data-faq-add]').addEventListener('click', () => {
            const row = $('.faq', faqs).cloneNode(true);
            $$('input, textarea', row).forEach((el) => (el.value = ''));
            faqs.appendChild(row);
            reindex();
            $('input', row).focus();
        });
        faqs.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-faq-remove]');
            if (!btn) return;
            const rows = $$('.faq', faqs);
            if (rows.length === 1) { $$('input, textarea', rows[0]).forEach((el) => (el.value = '')); return; }
            btn.closest('.faq').remove();
            reindex();
        });
    }

    // Counters + Google preview
    const form = $('#landingForm');
    const field = (n) => form && form.elements.namedItem(n);
    function updateSerp() {
        if (!form) return;
        const name = (field('name') && field('name').value) || 'Page title';
        const mt = field('meta_title'), md = field('meta_description'), sd = field('short_description');
        const t = $('[data-serp-title]'), d = $('[data-serp-desc]'), sl = $('[data-serp-slug]');
        if (t) t.textContent = (mt && mt.value) || name + ' in Coimbatore | ANP Nursing Home';
        if (d) d.textContent = (md && md.value) || (sd && sd.value) || 'Add a meta description so Google shows a helpful summary of this page.';
        if (sl) sl.textContent = (tgt && (tgt.value || tgt.placeholder !== 'auto from name' && tgt.placeholder)) || slugify(name) || 'page';
        $$('[data-max]', form).forEach((el) => {
            const c = $('[data-counter-for="' + el.name + '"]', form);
            if (!c) return;
            const len = el.value.length, max = +el.dataset.max;
            c.textContent = len + ' / ' + max;
            c.className = len === 0 ? '' : len > max ? 'c-bad' : len >= max * 0.6 ? 'c-good' : 'c-mid';
        });
    }
    if (form) { form.addEventListener('input', updateSerp); updateSerp(); }

    // Rich text editor (falls back to plain textarea when Quill can't load)
    window.addEventListener('load', () => {
        $$('[data-editor]').forEach((holder) => {
            const ta = holder.nextElementSibling;
            if (!window.Quill || !ta) { holder.remove(); ta && ta.classList.add('is-plain'); return; }
            const q = new Quill(holder, {
                theme: 'snow',
                placeholder: 'Write about this department – overview, approach, doctors…',
                modules: { toolbar: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['link', 'blockquote'], ['clean']] },
            });
            q.clipboard.dangerouslyPasteHTML(ta.value || '');
            ta.closest('form').addEventListener('submit', () => { ta.value = q.root.innerHTML === '<p><br></p>' ? '' : q.root.innerHTML; });
        });
    });
})();
