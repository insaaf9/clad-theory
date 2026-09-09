<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Logout — Clad Theory Admin</title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --brand-pink: #d5155f;
            --brand-pink-deep: #b6084c;
            --admin-bg: #f4f2f7;
            --admin-surface: #ffffff;
            --admin-border: rgba(0, 0, 0, 0.07);
            --admin-text: #18151f;
            --admin-muted: rgba(24, 21, 31, 0.62);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: grid;
            place-items: center;

            font-family: 'Inter', sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #f8f4f8 0%,
                    var(--admin-bg) 100%
                );

            color: var(--admin-text);
        }

        .logout-page {
            width: min(460px, calc(100% - 2rem));
        }

        .logout-card {
            background: var(--admin-surface);

            border: 1px solid var(--admin-border);

            border-radius: 22px;

            box-shadow:
                0 20px 52px rgba(16, 10, 18, 0.08);

            padding: 2rem;
        }

        .logout-badge {
            display: inline-flex;

            width: 52px;
            height: 52px;

            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    var(--brand-pink),
                    var(--brand-pink-deep)
                );

            color: #fff;

            font-size: 1.3rem;
            font-weight: 800;

            margin-bottom: 1rem;
        }

        .logout-card h1 {
            margin: 0 0 0.55rem;

            font-size: clamp(1.8rem, 3vw, 2.4rem);

            line-height: 1.15;
        }

        .logout-card p {
            margin: 0 0 1.5rem;

            color: var(--admin-muted);

            line-height: 1.6;
        }

        .logout-actions {
            display: flex;

            gap: 0.8rem;

            flex-wrap: wrap;
        }

        .logout-btn,
        .logout-cancel {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 46px;

            padding: 0.8rem 1.2rem;

            border-radius: 12px;

            text-decoration: none;

            font-weight: 700;

            cursor: pointer;

            border: 1px solid transparent;

            transition:
                transform 0.2s ease,
                opacity 0.2s ease,
                background 0.2s ease;
        }

        .logout-btn {

            background:
                linear-gradient(
                    135deg,
                    var(--brand-pink),
                    var(--brand-pink-deep)
                );

            color: #fff;

            border-color:
                rgba(213, 21, 95, 0.2);
        }

        .logout-cancel {

            background: #f6f4f8;

            color: var(--admin-text);

            border-color: var(--admin-border);
        }

        .logout-btn:hover,
        .logout-cancel:hover {

            transform: translateY(-1px);
        }

        form {
            margin: 0;
        }

    </style>

</head>

<body>

    <main class="logout-page">

        <section
            class="logout-card"
            aria-label="Logout confirmation"
        >

            <div class="logout-badge">
                ↪
            </div>

            <h1>
                Logout
            </h1>

            <p>
                Are you sure you want to sign out from the
                Clad Theory admin panel?
            </p>

            <div class="logout-actions">

                <a
                    href="dashboard.php"
                    class="logout-cancel"
                >
                    Cancel
                </a>

                <form
                    method="post"
                    action="logout.php"
                >

                    <button
                        type="submit"
                        class="logout-btn"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </section>

    </main>

</body>

</html>