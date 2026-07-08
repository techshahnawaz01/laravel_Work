import './bootstrap';

const storageKey = 'task-laravel-theme';

const applyTheme = (theme) => {
    document.documentElement.classList.toggle('dark', theme === 'dark');
};

applyTheme(localStorage.getItem(storageKey) ?? 'dark');

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-theme-toggle]');

    if (toggle) {
        const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
        localStorage.setItem(storageKey, nextTheme);
        applyTheme(nextTheme);
    }

    const dismiss = event.target.closest('[data-toast-dismiss]');

    if (dismiss) {
        dismiss.closest('[data-toast]')?.remove();
    }

    const trigger = event.target.closest('[data-confirm]');

    if (trigger) {
        event.preventDefault();

        const modal = document.querySelector('[data-confirm-modal]');
        const title = modal?.querySelector('[data-confirm-title]');
        const text = modal?.querySelector('[data-confirm-text]');
        const formId = trigger.getAttribute('data-confirm-form');
        const form = formId ? document.getElementById(formId) : trigger.closest('form');

        if (!modal || !form) {
            return;
        }

        modal.dataset.confirmForm = form.id;
        title.textContent = trigger.getAttribute('data-confirm-title') ?? 'Confirm action';
        text.textContent = trigger.getAttribute('data-confirm-message') ?? 'This action cannot be undone.';
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    if (event.target.closest('[data-confirm-cancel]')) {
        const modal = document.querySelector('[data-confirm-modal]');
        modal?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (event.target.closest('[data-confirm-submit]')) {
        const modal = document.querySelector('[data-confirm-modal]');
        const formId = modal?.dataset.confirmForm;
        const form = formId ? document.getElementById(formId) : null;

        if (form) {
            form.requestSubmit();
        }
    }
});

document.addEventListener('submit', (event) => {
    const button = event.target.querySelector('[data-loading-button]');

    if (!button) {
        return;
    }

    button.disabled = true;
    button.dataset.originalText = button.textContent;
    button.textContent = button.getAttribute('data-loading-text') ?? 'Working...';
});

window.setTimeout(() => {
    document.querySelectorAll('[data-toast]').forEach((toast) => {
        toast.remove();
    });
}, 4000);
