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
        $$('a', nav).forEach((a) => a.addEventListener('click', () => setMenu(false)));
        document.addEventListener('click', (e) => {
            if (document.body.classList.contains('menu-open') && !nav.contains(e.target) && !burger.contains(e.target)) setMenu(false);
        });
        document.addEventListener('keydown', (e) => e.key === 'Escape' && setMenu(false));
    }

    /* ---------- Hero slider ---------- */
    const slider = $('#heroSlider');
    if (slider) {
        const slides = $$('.slide', slider);
        const dots = $$('.slider__dot', slider);
        const DELAY = 5500;
        let index = 0;
        let timer = null;
        slider.style.setProperty('--delay', DELAY + 'ms');

        const go = (i) => {
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
        const play = () => { stop(); if (!reduceMotion) timer = setInterval(() => go(index + 1), DELAY); };
        const stop = () => { clearInterval(timer); timer = null; };

        $('.slider__arrow--next', slider).addEventListener('click', () => { go(index + 1); play(); });
        $('.slider__arrow--prev', slider).addEventListener('click', () => { go(index - 1); play(); });
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

    /* ---------- Appointment form → WhatsApp ---------- */
    const form = $('#appointmentForm');
    if (form) {
        const dept = new URLSearchParams(location.search).get('dept');
        const select = $('#deptSelect', form);
        if (dept && select) {
            const match = Array.from(select.options).find((o) => o.text.toLowerCase() === dept.toLowerCase());
            if (match) match.selected = true;
            else select.add(new Option(dept, dept, true, true), 1);
        }
        const date = $('input[type=date]', form);
        if (date) date.min = new Date().toISOString().split('T')[0];

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(form).entries());
            const err = $('.form__error', form);
            const nameOk = data.name.trim().length > 1;
            const phoneOk = /^[0-9+\s]{10,15}$/.test(data.phone.trim());
            form.elements.namedItem('name').classList.toggle('is-invalid', !nameOk);
            form.elements.namedItem('phone').classList.toggle('is-invalid', !phoneOk);
            err.hidden = nameOk && phoneOk;
            if (!err.hidden) return;

            const lines = [
                'Hello ANP Nursing Home, I would like to book an appointment.',
                '',
                '*Name:* ' + data.name.trim(),
                '*Phone:* ' + data.phone.trim(),
            ];
            if (data.dept) lines.push('*Department:* ' + data.dept);
            if (data.date) lines.push('*Preferred date:* ' + data.date.split('-').reverse().join('-'));
            if (data.message.trim()) lines.push('*Message:* ' + data.message.trim());

            window.open('https://wa.me/' + form.dataset.whatsapp + '?text=' + encodeURIComponent(lines.join('\n')), '_blank', 'noopener');
            form.reset();
        });
    }
})();
