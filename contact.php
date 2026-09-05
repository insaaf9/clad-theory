<?php
$pageTitle = 'Contact Us | Jack Ryan';
$bodyClass = 'contact-page';
$currentPage = 'contact';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<main class="contact-hero">
    <div class="contact-hero__inner">
        <div class="contact-hero__label">Contacts</div>
        <h1>GET IN TOUCH AND FIND US</h1>
        <p>Globally e-enable an expanded array of bandwidth before process-centric deliverables.</p>
    </div>
</main>

<section class="contact-wrap">
    <div class="contact-grid">
        <div class="contact-info">
            <div class="contact-row">
                <div class="contact-label">ADDRESS</div>
                <div class="contact-value">88 Whitby Road<br>IP20 6JA<br>London, UK</div>
            </div>

            <div class="contact-row">
                <div class="contact-label">EMAIL</div>
                <div class="contact-value"><a href="mailto:hello@myemail.com">hello@myemail.com</a></div>
            </div>

            <div class="contact-row">
                <div class="contact-label">PHONE</div>
                <div class="contact-value">+44 7356 6487<br><span>Mon - Fri, 8AM - 7PM</span></div>
            </div>

            <div class="contact-row contact-row--socials">
                <div class="contact-label">SOCIALS</div>
                <div class="contact-value">
                    <div class="social-icons">
                        <a href="#" aria-label="Twitter">𝕏</a>
                        <a href="#" aria-label="Instagram">◎</a>
                        <a href="#" aria-label="Facebook">f</a>
                        <a href="#" aria-label="Dribbble">◌</a>
                    </div>
                </div>
            </div>
        </div>

        <form class="contact-form" action="#" method="post">
            <div class="field-row field-row--two">
                <label>
                    <input type="text" placeholder="Your name" aria-label="Your name">
                </label>
                <label>
                    <input type="email" placeholder="Your email" aria-label="Your email">
                </label>
            </div>

            <div class="field-row">
                <label>
                    <input type="text" placeholder="Your subject" aria-label="Your subject">
                </label>
            </div>

            <div class="field-row">
                <label>
                    <textarea placeholder="Your message" aria-label="Your message" rows="7"></textarea>
                </label>
            </div>

            <label class="checkbox-row">
                <input type="checkbox">
                <span>I consent to the conditions.</span>
            </label>

            <button type="submit" class="submit-btn">Send</button>
        </form>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
