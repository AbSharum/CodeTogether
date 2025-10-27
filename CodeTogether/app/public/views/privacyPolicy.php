<?php
// privacy.php
declare(strict_types=1);

$siteName     = 'CodeTogether';
$companyName  = 'Code Together LLC';
$contactEmail = 'legal@CodeTogether.com';
$jurisdiction = 'State of Arkansas, USA';
$lastUpdated  = date('F j, Y');

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Privacy Policy | <?php echo e($siteName); ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root { --fg:#111; --muted:#555; --bg:#fff; --card:#fafafa; --link:#0a58ca; }
    body { margin:0; font:16px/1.6 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; color:var(--fg); background:var(--bg); }
    header,main,footer { max-width:900px; margin:0 auto; padding:24px; }
    header { padding-top:32px; }
    h1 { margin:0 0 8px; }
    .updated { color:var(--muted); font-size:0.95rem; }
    nav { background:var(--card); border:1px solid #e7e7e7; border-radius:10px; padding:12px 16px; margin:16px 0 24px; }
    nav a { margin-right:12px; color:var(--link); text-decoration:none; }
    section { margin:24px 0; }
    h2 { margin:0 0 8px; font-size:1.25rem; }
    ul { padding-left:20px; }
    a { color:var(--link); }
    .card { background:var(--card); border:1px solid #e7e7e7; border-radius:10px; padding:16px; }
    footer { color:var(--muted); font-size:0.9rem; padding-bottom:48px; }
  </style>
</head>
<body>
  <header>
    <h1>Privacy Policy</h1>
    <div class="updated">Last updated: <?php echo e($lastUpdated); ?></div>
    <p>This Privacy Policy explains how <?php echo e($companyName); ?> (“we”, “our”, “us”) collects, uses, and protects information when you use <?php echo e($siteName); ?>.</p>
  </header>

  <main>
    <nav class="card">
      <strong>Jump to:</strong>
      <a href="#information">Information We Collect</a>
      <a href="#usage">How We Use Information</a>
      <a href="#sharing">Information Sharing</a>
      <a href="#cookies">Cookies</a>
      <a href="#security">Security</a>
      <a href="#data-rights">Your Data Rights</a>
      <a href="#retention">Data Retention</a>
      <a href="#children">Children’s Privacy</a>
      <a href="#international">International Transfers</a>
      <a href="#changes">Changes</a>
      <a href="#contact">Contact</a>
    </nav>

    <section id="information">
      <h2>1. Information We Collect</h2>
      <p>We collect the following types of information:</p>
      <ul>
        <li><strong>Account Information:</strong> Username, email, password hash, and profile details you provide when registering.</li>
        <li><strong>Content:</strong> Posts, messages, and media you upload.</li>
        <li><strong>Usage Data:</strong> Log data such as IP address, browser type, device information, and access times.</li>
        <li><strong>Cookies and Tracking:</strong> Data collected through cookies, analytics tools, and similar technologies.</li>
      </ul>
    </section>

    <section id="usage">
      <h2>2. How We Use Information</h2>
      <ul>
        <li>Provide, maintain, and improve <?php echo e($siteName); ?>.</li>
        <li>Personalize content and recommendations.</li>
        <li>Communicate updates, security notices, or support messages.</li>
        <li>Detect, prevent, and address fraud or abuse.</li>
        <li>Comply with legal obligations.</li>
      </ul>
    </section>

    <section id="sharing">
      <h2>3. Information Sharing</h2>
      <p>We do not sell personal information. We may share information:</p>
      <ul>
        <li>With service providers that help operate <?php echo e($siteName); ?> (e.g., hosting, analytics, payment processing).</li>
        <li>To comply with law, regulation, or legal process.</li>
        <li>In connection with a merger, acquisition, or sale of assets.</li>
        <li>With your consent or as otherwise disclosed at the time of collection.</li>
      </ul>
    </section>

    <section id="cookies">
      <h2>4. Cookies and Tracking Technologies</h2>
      <p>We use cookies to remember preferences, maintain sessions, and analyze traffic. You can control cookies through your browser settings, but some features may not function correctly if you disable them.</p>
    </section>

    <section id="security">
      <h2>5. Data Security</h2>
      <p>We use reasonable administrative, technical, and physical safeguards to protect your information. However, no system is completely secure, and we cannot guarantee absolute security.</p>
    </section>

    <section id="data-rights">
      <h2>6. Your Data Rights</h2>
      <ul>
        <li>Access, correct, or delete your personal data through your account settings.</li>
        <li>Withdraw consent where processing is based on consent.</li>
        <li>Request a copy of your data in a portable format (subject to applicable law).</li>
        <li>Object to or restrict certain processing activities.</li>
      </ul>
      <p>To exercise these rights, contact us at <a href="mailto:<?php echo e($contactEmail); ?>"><?php echo e($contactEmail); ?></a>.</p>
    </section>

    <section id="retention">
      <h2>7. Data Retention</h2>
      <p>We retain information for as long as necessary to provide the Service, comply with legal obligations, resolve disputes, and enforce agreements. Account data may be deleted upon request or account closure.</p>
    </section>

    <section id="children">
      <h2>8. Children’s Privacy</h2>
      <p><?php echo e($siteName); ?> is not directed at children under 13. We do not knowingly collect information from children under 13. If you believe we have collected such data, contact us to remove it.</p>
    </section>

    <section id="international">
      <h2>9. International Data Transfers</h2>
      <p>If you are located outside the United States, your information may be transferred to and processed in the United States or other countries that may not provide the same level of data protection.</p>
    </section>

    <section id="changes">
      <h2>10. Changes to This Policy</h2>
      <p>We may update this Privacy Policy periodically. Changes will be posted here with a revised “Last updated” date. Continued use of the Service after changes means you accept the new policy.</p>
    </section>

    <section id="contact" class="card">
      <h2>Contact</h2>
      <p>For privacy questions or data requests, email <a href="mailto:<?php echo e($contactEmail); ?>"><?php echo e($contactEmail); ?></a>.</p>
      <p>Legal entity: <?php echo e($companyName); ?></p>
    </section>
  </main>

  <footer>
    &copy; <?php echo date('Y'); ?> <?php echo e($companyName); ?>. All rights reserved.
  </footer>
</body>
</html>
