<?php
// terms.php
declare(strict_types=1);

// Basic config. Edit these.
$siteName     = 'CodeTogether';
$companyName  = 'Code Together LLC';
$contactEmail = 'legal@CodeTogether.com';
$jurisdiction = 'State of Arkansas, USA';

// Auto "Last Updated"
$lastUpdated = date('F j, Y');

// Simple escape helper
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// If you store a canonical "last updated" date, replace the auto date above.
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Terms of Service | <?php echo e($siteName); ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root { --fg:#111; --muted:#555; --bg:#fff; --card:#fafafa; --link:#0a58ca; }
    * { box-sizing:border-box }
    body { margin:0; font:16px/1.6 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color:var(--fg); background:var(--bg); }
    header, main, footer { max-width:900px; margin:0 auto; padding:24px; }
    header { padding-top:32px }
    h1 { margin:0 0 8px }
    .updated { color:var(--muted); font-size:0.95rem }
    nav { background:var(--card); border:1px solid #e7e7e7; border-radius:10px; padding:12px 16px; margin:16px 0 24px }
    nav a { margin-right:12px; color:var(--link); text-decoration:none }
    section { margin:24px 0; }
    h2 { margin:0 0 8px; font-size:1.25rem }
    ul { padding-left:20px }
    a { color:var(--link) }
    .card { background:var(--card); border:1px solid #e7e7e7; border-radius:10px; padding:16px }
    footer { color:var(--muted); font-size:0.9rem; padding-bottom:48px }
    code { background:#f3f3f3; padding:2px 6px; border-radius:6px }
  </style>
</head>
<body>
  <header>
    <h1>Terms of Service</h1>
    <div class="updated">Last updated: <?php echo e($lastUpdated); ?></div>
    <p>These Terms of Service (“Terms”) govern your access to and use of <?php echo e($siteName); ?>. By accessing or using <?php echo e($siteName); ?>, you agree to be bound by these Terms.</p>
  </header>

  <main>
    <nav class="card">
      <strong>Jump to:</strong>
      <a href="#eligibility">Eligibility</a>
      <a href="#accounts">Accounts</a>
      <a href="#user-content">User Content</a>
      <a href="#prohibited">Prohibited Conduct</a>
      <a href="#ip">Intellectual Property</a>
      <a href="#privacy">Privacy</a>
      <a href="#payments">Payments</a>
      <a href="#third-party">Third-Party Services</a>
      <a href="#termination">Termination</a>
      <a href="#disclaimers">Disclaimers</a>
      <a href="#limitation">Limitation of Liability</a>
      <a href="#indemnity">Indemnity</a>
      <a href="#governing-law">Governing Law</a>
      <a href="#changes">Changes</a>
      <a href="#contact">Contact</a>
    </nav>

    <section id="acceptance">
      <h2>1. Acceptance of Terms</h2>
      <p>By creating an account, accessing, or using <?php echo e($siteName); ?>, you confirm that you have read, understood, and agree to these Terms.</p>
    </section>

    <section id="eligibility">
      <h2>2. Eligibility</h2>
      <p>You must be at least 13 years old to use <?php echo e($siteName); ?>. If you are under the age of majority in your location, you may use the Service only with consent of a parent or legal guardian.</p>
    </section>

    <section id="accounts">
      <h2>3. Accounts and Security</h2>
      <ul>
        <li>You are responsible for your account credentials and all activity under your account.</li>
        <li>Maintain accurate account information and update it as needed.</li>
        <li>Notify us immediately of any unauthorized use or security breach.</li>
      </ul>
    </section>

    <section id="user-content">
      <h2>4. User Content</h2>
      <ul>
        <li>You retain ownership of content you post.</li>
        <li>By posting, you grant <?php echo e($companyName); ?> a worldwide, non-exclusive, royalty-free license to host, store, reproduce, modify, adapt, publish, translate, and display your content for operating and improving the Service.</li>
        <li>You represent that you have all rights necessary to grant this license and that your content does not violate law or third-party rights.</li>
      </ul>
    </section>

    <section id="prohibited">
      <h2>5. Prohibited Conduct</h2>
      <ul>
        <li>Illegal activity or violation of others’ rights.</li>
        <li>Harassment, hate speech, or incitement of violence.</li>
        <li>Posting sexually explicit content involving minors or otherwise exploitative material.</li>
        <li>Malware, phishing, or attempts to gain unauthorized access.</li>
        <li>Automated scraping without written permission.</li>
        <li>Impersonation or misrepresentation of affiliation.</li>
        <li>Circumventing technical measures or rate limits.</li>
      </ul>
    </section>

    <section id="ip">
      <h2>6. Intellectual Property</h2>
      <p>The Service, including software, visual design, logos, and trademarks, are owned by <?php echo e($companyName); ?> or its licensors and are protected by applicable laws. Except as expressly permitted, you may not copy, modify, distribute, or create derivative works of the Service.</p>
    </section>

    <section id="privacy">
      <h2>7. Privacy</h2>
      <p>Your use of the Service is subject to our Privacy Policy. If you do not agree with the processing of your information as described there, do not use the Service.</p>
    </section>

    <section id="payments">
      <h2>8. Payments; Refunds</h2>
      <ul>
        <li>Fees, if any, will be disclosed before purchase. Taxes may apply.</li>
        <li>All payments are final unless required by law or our posted refund policy.</li>
        <li>We may change prices on a go-forward basis with notice.</li>
      </ul>
    </section>

    <section id="third-party">
      <h2>9. Third-Party Services</h2>
      <p><?php echo e($siteName); ?> may link to or integrate third-party services. We do not control and are not responsible for those services. Use them at your own risk and subject to their terms.</p>
    </section>

    <section id="termination">
      <h2>10. Suspension and Termination</h2>
      <ul>
        <li>We may suspend or terminate access for any violation of these Terms or to protect the Service or users.</li>
        <li>You may stop using the Service at any time. Certain provisions survive termination, including ownership, disclaimers, limitations of liability, and indemnity.</li>
      </ul>
    </section>

    <section id="disclaimers">
      <h2>11. Disclaimers</h2>
      <p>The Service is provided “AS IS” and “AS AVAILABLE” without warranties of any kind, express or implied, including merchantability, fitness for a particular purpose, and non-infringement. We do not warrant that the Service will be uninterrupted, secure, or error-free.</p>
    </section>

    <section id="limitation">
      <h2>12. Limitation of Liability</h2>
      <p>To the maximum extent permitted by law, <?php echo e($companyName); ?> will not be liable for indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly, or any loss of data, use, goodwill, or other intangible losses, resulting from your use of the Service.</p>
    </section>

    <section id="indemnity">
      <h2>13. Indemnity</h2>
      <p>You agree to indemnify and hold harmless <?php echo e($companyName); ?> and its affiliates, officers, employees, and agents from any claims, damages, liabilities, and expenses arising from your use of the Service or your violation of these Terms.</p>
    </section>

    <section id="governing-law">
      <h2>14. Governing Law; Dispute Resolution</h2>
      <p>These Terms are governed by the laws of <?php echo e($jurisdiction); ?>, without regard to conflicts of law principles. Jurisdiction and venue lie exclusively in courts located in <?php echo e($jurisdiction); ?>.</p>
      <p>If you are an EU or UK consumer, you may have mandatory rights under local law that override the foregoing to the extent required.</p>
    </section>

    <section id="changes">
      <h2>15. Changes to the Service or Terms</h2>
      <p>We may modify the Service or these Terms at any time. Material changes will be posted here with a new “Last updated” date. Continued use after changes means you accept the updated Terms.</p>
    </section>

    <section id="misc">
      <h2>16. Miscellaneous</h2>
      <ul>
        <li>If any provision is unenforceable, the rest remain in effect.</li>
        <li>Failure to enforce a provision is not a waiver.</li>
        <li>You may not assign these Terms without our consent. We may assign them as part of a merger, acquisition, or asset sale.</li>
        <li>These Terms, plus any referenced policies, are the entire agreement between you and us about the Service.</li>
      </ul>
    </section>

    <section id="contact" class="card">
      <h2>Contact</h2>
      <p>Questions about these Terms: <a href="mailto:<?php echo e($contactEmail); ?>"><?php echo e($contactEmail); ?></a></p>
      <p>Legal entity: <?php echo e($companyName); ?></p>
    </section>
  </main>

  <footer>
    &copy; <?php echo date('Y'); ?> <?php echo e($companyName); ?>. All rights reserved.
  </footer>
</body>
</html>
