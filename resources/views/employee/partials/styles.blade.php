@once
@push('styles')
<style>
    .employee-shell {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 2.5rem 1rem 4rem;
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    /* Hero banner ala katalog */
    .employee-hero-banner {
        width: 100%;
        max-width: 1280px;
        margin: 0 auto 2rem;
        padding: 2.75rem 1.5rem;
        border: 1.5px solid rgba(163, 230, 53, 0.8);
        border-radius: 22px;
        background: rgba(42, 71, 63, 0.7);
        backdrop-filter: blur(10px);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.12);
        text-align: center;
    }

    .employee-hero-inner {
        max-width: 960px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        color: #f8fafc;
    }

    .employee-hero-title {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 2.1rem;
        font-weight: 800;
        color: #a3e635;
        letter-spacing: 0.02em;
    }

    .employee-hero-icon {
        font-size: 2.1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .employee-hero-subtitle {
        font-size: 1.05rem;
        color: #e2e8f0;
        margin: 0;
        line-height: 1.6;
    }

    @media (max-width: 640px) {
        .employee-hero-banner {
            padding: 2.25rem 1.25rem;
        }
        .employee-hero-title {
            font-size: 1.65rem;
        }
        .employee-hero-icon {
            font-size: 1.65rem;
        }
        .employee-hero-subtitle {
            font-size: 0.98rem;
        }
    }

    .employee-hero {
        display: grid;
        gap: 1.5rem;
        padding: 2.25rem;
        color: #f8fafc;
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        align-items: flex-start;
    }
        gap: 1.75rem;
    .employee-hero__badge {
        display: inline-flex;

    .employee-stack-gap > * + * {
        margin-top: 1.5rem;
    }

    @media (min-width: 768px) {
        .employee-stack-gap > * + * {
            margin-top: 2rem;
        }
    }
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.95rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .employee-hero__actions {
        margin-left: auto;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    .employee-grid {
        display: grid;
        gap: 1.25rem;
    }

    .employee-grid--stats {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }

    .employee-grid--profile {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .employee-card {
        background: rgba(255, 255, 255, 0.94);
        border-radius: 1.75rem;
        padding: 1.75rem;
        border: 1px solid rgba(148, 163, 184, 0.22);
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(8px);
    }

    .employee-card--stat {
        position: relative;
        overflow: hidden;
    }

    .employee-card--stat::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.08));
        opacity: 0;
        transition: opacity 0.2s ease;
        border-radius: inherit;
        pointer-events: none;
    }

    .employee-card--stat:hover::after {
        opacity: 1;
    }

    .employee-card__label {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        margin-bottom: 0.4rem;
    }

    .employee-card__value {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .employee-card__helper {
        font-size: 0.95rem;
        color: #64748b;
        margin-top: 0.35rem;
    }

    .employee-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .employee-info-list li {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.95rem;
        color: #475569;
    }

    .employee-divider {
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.4), transparent);
        margin: 1.5rem 0;
    }

    .employee-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 999px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .employee-btn:focus-visible {
        outline: 3px solid rgba(59, 130, 246, 0.35);
        outline-offset: 2px;
    }

    .employee-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
    }

    .employee-btn--primary {
        background: linear-gradient(135deg, #22c55e, #15803d);
        color: #f8fafc;
    }

    .employee-btn--accent {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: #fff7ed;
    }

    .employee-btn--ghost {
        background: rgba(15, 23, 42, 0.05);
        color: #0f172a;
        border: 1px solid rgba(15, 23, 42, 0.12);
    }

    .employee-btn--danger {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
        color: #fff;
    }

    .employee-inline-form {
        display: inline-flex;
        margin: 0;
    }

    .employee-inline-form button {
        width: 100%;
    }

    .employee-alert {
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1rem;
    }

    .employee-alert--success {
        background: rgba(34, 197, 94, 0.12);
        color: #166534;
        border: 1px solid rgba(22, 101, 52, 0.2);
    }

    .employee-alert--error {
        background: rgba(248, 113, 113, 0.12);
        color: #b91c1c;
        border: 1px solid rgba(185, 28, 28, 0.2);
    }

    .employee-avatar {
        width: 144px;
        height: 144px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.05);
        display: grid;
        place-items: center;
        overflow: hidden;
        margin: 0 auto 1rem;
        border: 3px solid rgba(96, 165, 250, 0.35);
        box-shadow: 0 15px 35px rgba(30, 64, 175, 0.15);
    }

    .employee-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .employee-form-grid {
        display: grid;
        gap: 1.25rem;
    }

    @media (min-width: 768px) {
        .employee-form-grid--two-cols {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .employee-form-group label {
        display: block;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0.45rem;
    }

    .employee-form-group input {
        width: 100%;
        border-radius: 0.9rem;
        border: 1px solid rgba(148, 163, 184, 0.6);
        padding: 0.75rem 1rem;
        background: rgba(248, 250, 252, 0.9);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .employee-form-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        outline: none;
        background: #fff;
    }

    .employee-form-note {
        font-size: 0.85rem;
        color: #475569;
        margin-top: 0.5rem;
    }

    .employee-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.85rem;
        align-items: center;
    }

    .employee-auth {
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
        padding: 3rem 1rem 4rem;
    }

    .employee-auth__card {
        border-radius: 2rem;
        padding: 2.5rem;
        background: rgba(15, 23, 42, 0.7);
        color: #e2e8f0;
        border: 1px solid rgba(148, 163, 184, 0.25);
        box-shadow: 0 25px 55px rgba(15, 23, 42, 0.45);
    }

    .employee-auth__card h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .employee-auth__card p {
        margin-bottom: 2rem;
        color: #cbd5f5;
    }

    .employee-auth__card label {
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 0.4rem;
        display: block;
    }

    .employee-auth__card input {
        background: rgba(15, 23, 42, 0.55);
        border: 1px solid rgba(148, 163, 184, 0.55);
        border-radius: 0.9rem;
        padding: 0.75rem 1rem;
        width: 100%;
        color: #f8fafc;
    }

    .employee-auth__card input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 2px rgba(147, 197, 253, 0.35);
        outline: none;
    }

    .employee-auth__meta {
        font-size: 0.85rem;
        color: #94a3b8;
    }

    @media (max-width: 640px) {
        .employee-hero {
            padding: 1.75rem;
        }

        .employee-card {
            padding: 1.5rem;
            border-radius: 1.25rem;
        }

        .employee-btn {
            width: 100%;
        }

        .employee-hero__actions {
            flex-direction: column;
            width: 100%;
        }
    }
</style>
@endpush
@endonce
