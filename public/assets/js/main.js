/* ANP Nursing Home – site interactions (no dependencies) */
(function () {
    'use strict';

    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Sticky header + back-to-top ---------- */
    const header = $('#header');
    const toTop = $('#toTop');
    const onScroll = () => {
        const y = window.scrollY;
        header && header.classList.toggle('is-scrolled', y > 40);
        toTop && toTop.classList.toggle('is-visible', y > 600);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    toTop && toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* ---------- Mobile menu ---------- */
    const burger = $('#burger');
    const nav = $('#nav');
    const setMenu = (open) => {
        nav.classList.toggle('is-open', open);
        burger.classList.toggle('is-open', open);
        burger.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('menu-open', open);
    };
    if (burger && nav) {
        burger.addEventListener('click', () => setMenu(!nav.classList.contains('is-open')));
        $$('a:not(.nav__viewall)', nav).forEach((a) => a.addEventListener('click', () => setMenu(false)));
        document.addEventListener('click', (e) => {
            if (document.body.classList.contains('menu-open') && !nav.contains(e.target) && !burger.contains(e.target)) setMenu(false);
        });
        document.addEventListener('keydown', (e) => e.key === 'Escape' && setMenu(false));
    }

    /* ---------- Hero slider ---------- */
    const slider = $('#heroSlider');
    if (slider) {
        const slides = $$('.slide', slider);
        const dots = $$('.slider__dot', document.getElementById('heroDots') || slider);
        const DELAY = 5500;
        let index = 0;
        let timer = null;
        slider.style.setProperty('--delay', DELAY + 'ms');

        const go = (i) => {
            if (slides.length < 2) return;
            slides[index].classList.remove('is-active');
            dots[index].classList.remove('is-active');
            index = (i + slides.length) % slides.length;
            slides[index].classList.add('is-active');
            // restart the dot progress animation
            const dot = dots[index];
            dot.classList.remove('is-active');
            void dot.offsetWidth;
            dot.classList.add('is-active');
        };
        const play = () => { stop(); if (!reduceMotion && slides.length > 1) timer = setInterval(() => go(index + 1), DELAY); };
        const stop = () => { clearInterval(timer); timer = null; };

        const nextBtn = $('.slider__arrow--next', slider), prevBtn = $('.slider__arrow--prev', slider);
        nextBtn && nextBtn.addEventListener('click', () => { go(index + 1); play(); });
        prevBtn && prevBtn.addEventListener('click', () => { go(index - 1); play(); });
        dots.forEach((d, i) => d.addEventListener('click', () => { go(i); play(); }));

        slider.addEventListener('mouseenter', () => { stop(); slider.classList.add('is-paused'); });
        slider.addEventListener('mouseleave', () => { play(); slider.classList.remove('is-paused'); });

        // swipe
        let startX = null;
        slider.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
        slider.addEventListener('touchend', (e) => {
            if (startX === null) return;
            const dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 40) { go(index + (dx < 0 ? 1 : -1)); play(); }
            startX = null;
        });

        // keyboard
        slider.setAttribute('tabindex', '0');
        slider.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') { go(index + 1); play(); }
            if (e.key === 'ArrowLeft') { go(index - 1); play(); }
        });

        document.addEventListener('visibilitychange', () => (document.hidden ? stop() : play()));
        play();
    }

    /* ---------- Tabs ---------- */
    $$('.tabs').forEach((tabs) => {
        const section = tabs.closest('section');
        $$('.tabs__btn', tabs).forEach((btn) => {
            btn.addEventListener('click', () => {
                $$('.tabs__btn', tabs).forEach((b) => b.classList.toggle('is-active', b === btn));
                $$('.tab-panel', section).forEach((p) => {
                    const on = p.dataset.panel === btn.dataset.tab;
                    p.classList.toggle('is-active', on);
                    if (on) updateCarousel(p.querySelector('[data-carousel]'));
                });
            });
        });
    });

    /* ---------- Carousels ---------- */
    function updateCarousel(c) {
        if (!c) return;
        const t = $('.carousel__track', c);
        const max = t.scrollWidth - t.clientWidth - 4;
        $('.carousel__btn--prev', c).disabled = t.scrollLeft <= 4;
        $('.carousel__btn--next', c).disabled = t.scrollLeft >= max;
    }
    $$('[data-carousel]').forEach((c) => {
        const t = $('.carousel__track', c);
        const step = () => (t.firstElementChild ? t.firstElementChild.getBoundingClientRect().width + 22 : 300);
        $('.carousel__btn--next', c).addEventListener('click', () => t.scrollBy({ left: step() }));
        $('.carousel__btn--prev', c).addEventListener('click', () => t.scrollBy({ left: -step() }));
        t.addEventListener('scroll', () => updateCarousel(c), { passive: true });
        window.addEventListener('resize', () => updateCarousel(c));
        updateCarousel(c);
    });

    /* ---------- Reveal on scroll + counters ---------- */
    const countUp = (el) => {
        const to = parseInt(el.dataset.to, 10) || 0;
        if (reduceMotion) { el.textContent = to; return; }
        const dur = 1800;
        const start = performance.now();
        const tick = (now) => {
            const p = Math.min((now - start) / dur, 1);
            el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    };

    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((en) => {
                if (!en.isIntersecting) return;
                en.target.classList.add('is-in');
                $$('.counter', en.target).forEach(countUp);
                io.unobserve(en.target);
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
        $$('.reveal').forEach((el, i) => {
            el.style.transitionDelay = (i % 4) * 80 + 'ms';
            io.observe(el);
        });
    } else {
        $$('.reveal').forEach((el) => el.classList.add('is-in'));
        $$('.counter').forEach(countUp);
    }

    /* ---------- Accordion: one open at a time ---------- */
    $$('.accordion').forEach((acc) => {
        const items = $$('details', acc);
        items.forEach((d) => d.addEventListener('toggle', () => {
            if (d.open) items.forEach((o) => o !== d && (o.open = false));
        }));
    });

    /* ---------- Lightbox ---------- */
    const lb = $('#lightbox');
    if (lb) {
        const img = $('img', lb);
        const close = () => { lb.classList.remove('is-open'); lb.setAttribute('aria-hidden', 'true'); };
        $$('[data-lightbox]').forEach((el) => el.addEventListener('click', () => {
            img.src = el.dataset.lightbox;
            img.alt = el.getAttribute('aria-label') || '';
            lb.classList.add('is-open');
            lb.setAttribute('aria-hidden', 'false');
        }));
        lb.addEventListener('click', (e) => { if (e.target !== img) close(); });
        document.addEventListener('keydown', (e) => e.key === 'Escape' && close());
    }

    /* ---------- Mobile: departments dropdown toggle ---------- */
    $$('[data-drop]').forEach((drop) => {
        const btn = $('.nav__toggle', drop);
        btn && btn.addEventListener('click', (e) => {
            e.preventDefault();
            const open = drop.classList.toggle('is-open');
            btn.setAttribute('aria-expanded', String(open));
        });
        const sub = $('.nav__sub', drop);
        const viewAll = sub && $('.nav__viewall', sub);
        viewAll && viewAll.addEventListener('click', (e) => {
            if (window.matchMedia('(max-width: 991px)').matches) { e.preventDefault(); sub.classList.toggle('is-open'); }
        });
    });

    /* ---------- Enquiry / appointment forms → saved to admin panel ---------- */
    const preDept = new URLSearchParams(location.search).get('dept');
    $$('.js-enquiry').forEach((form) => {
        const select = form.elements.namedItem('dept');
        if (preDept && select && !select.value) {
            const match = Array.from(select.options).find((o) => o.text.toLowerCase() === preDept.toLowerCase());
            if (match) match.selected = true;
            else select.add(new Option(preDept, preDept, true, true), 1);
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(form);
            const err = $('.form__error', form);
            const name = (fd.get('name') || '').trim();
            const phone = (fd.get('phone') || '').trim();
            const nameOk = name.length > 1;
            const phoneOk = /^[0-9+\s\-]{10,16}$/.test(phone) && phone.replace(/\D/g, '').length >= 10;
            form.elements.namedItem('name').classList.toggle('is-invalid', !nameOk);
            form.elements.namedItem('phone').classList.toggle('is-invalid', !phoneOk);
            if (!nameOk || !phoneOk) {
                err.textContent = 'Please enter your name and a valid 10-digit phone number.';
                err.hidden = false;
                return;
            }
            err.hidden = true;

            const btn = $('button[type=submit]', form);
            const label = $('span', btn);
            const old = label.textContent;
            btn.disabled = true;
            label.textContent = 'Sending…';

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd,
                });
                const json = await res.json().catch(() => ({}));
                if (!res.ok) {
                    const first = json.errors ? Object.values(json.errors)[0][0] : (res.status === 429 ? 'Too many requests. Please try again in a minute.' : 'Something went wrong. Please call us instead.');
                    err.textContent = first;
                    err.hidden = false;
                    return;
                }

                const lines = ['Hello ANP Nursing Home, I just requested an appointment.', '*Name:* ' + name, '*Phone:* ' + phone];
                if (fd.get('dept')) lines.push('*Department:* ' + fd.get('dept'));
                if (fd.get('date')) lines.push('*Preferred date:* ' + String(fd.get('date')).split('-').reverse().join('-'));
                const wa = 'https://wa.me/' + form.dataset.whatsapp + '?text=' + encodeURIComponent(lines.join('\n'));

                const esc = (t) => String(t).replace(/[&<>"']/g, (ch) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]));
                const rows = [['bi-person', 'Name', name], ['bi-telephone', 'Phone', phone]];
                if (fd.get('dept')) rows.push(['bi-hospital', 'Department', fd.get('dept')]);
                if (fd.get('date')) rows.push(['bi-calendar-event', 'Preferred date', new Date(fd.get('date') + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })]);

                const done = document.createElement('div');
                done.className = 'form__done';
                done.setAttribute('role', 'status');
                done.setAttribute('tabindex', '-1');
                done.innerHTML =
                    '<span class="form__done-icon"><i class="bi bi-check-lg"></i></span>' +
                    '<h4>Thank you, ' + esc(name.split(' ')[0]) + '!</h4>' +
                    '<p class="form__done-msg">' + esc(json.message || 'Our team will call you shortly to confirm.') + '</p>' +
                    (json.ref ? '<span class="form__done-ref">Reference No. <b>' + esc(json.ref) + '</b></span>' : '') +
                    '<ul class="form__done-list">' + rows.map((r) => '<li><i class="bi ' + r[0] + '"></i><span>' + r[1] + '</span><b>' + esc(r[2]) + '</b></li>').join('') + '</ul>' +
                    '<div class="form__done-actions">' +
                        '<a class="btn btn--wa" target="_blank" rel="noopener" href="' + wa + '"><i class="bi bi-whatsapp"></i> Send on WhatsApp</a>' +
                        '<button type="button" class="btn btn--ghost"><i class="bi bi-arrow-repeat"></i> New request</button>' +
                    '</div>';
                $('button', done).addEventListener('click', () => { done.remove(); form.hidden = false; form.elements.namedItem('name').focus(); });
                form.reset();
                form.hidden = true;
                form.after(done);
                done.focus({ preventScroll: true });
                const r = done.getBoundingClientRect();
                if (r.top < 90 || r.bottom > window.innerHeight) done.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } catch (x) {
                err.textContent = 'Network error. Please call +91 88707 77516.';
                err.hidden = false;
            } finally {
                btn.disabled = false;
                label.textContent = old;
            }
        });
    });
    /* ---------- Quick Enquiry drawer ---------- */
    const qe = document.getElementById('quickEnquiry');
    if (qe) {
        const setQe = (open) => {
            qe.classList.toggle('is-open', open);
            qe.setAttribute('aria-hidden', String(!open));
            document.body.classList.toggle('qe-open', open);
            if (open) setTimeout(() => { const f = qe.querySelector('input[name=name]'); f && f.focus(); }, 350);
        };
        $$('[data-qe-open]').forEach((b) => b.addEventListener('click', () => setQe(true)));
        $$('[data-qe-close]', qe).forEach((b) => b.addEventListener('click', () => setQe(false)));
        document.addEventListener('keydown', (e) => e.key === 'Escape' && setQe(false));
    }
})();
