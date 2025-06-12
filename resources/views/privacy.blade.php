@extends('components.layouts.app')

@section('title', 'Privacy Policy')

@push('css')
    <style>
        .child-privacy {
            margin: auto;
            width: 70%;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .child-privacy h1 {
            color: black;
            text-align: start !important;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 35px;
        }

        .child-privacy p {
            color: black;
            font-weight: 400;
            font-size: 15px;
            line-height: 25px;
        }

        .child-privacy ul li {
            margin-bottom: 10px;
            list-style: number;
        }

        .child-privacy h2 {
            color: black;
            font-weight: 500;
            font-size: 30px;
            margin: 30px 0;
        }

        .child-privacy table {
            margin: 40px 0;
        }

        .child-privacy table tr th {
            color: black;
            font-size: 16px;
            padding-bottom: 20px !important;
        }

        .child-privacy table tr td {
            padding-bottom: 15px;
        }

        .child-privacy ul li strong {
            color: black;
        }

        .child-privacy ul li ul li {
            list-style: none;
            position: relative;
            z-index: 0;
        }

        .child-privacy ul li ul li:before {
            position: absolute;
            z-index: 0;
            content: "";
            left: -20px;
            top: 10px;
            width: 8px;
            height: 8px;
            background: #ff0168;
            border-radius: 0;
        }

        .child-privacy ul li ul {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <section class="privacy-policy">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="child-privacy">
                        <h1 class="text-center">Magentick Photo Frames Privacy Policy</h1>
                        <p>This Privacy Policy applies to <a
                                href="https://www.magentickphotoframes.com">www.magentickphotoframes.com</a> (collectively,
                            "Magentick Photo Frames," "we," "our," or "us").</p>

                        <p>At Magentick Photo Frames, we are committed to protecting your personal data and ensuring it is
                            used responsibly. We aim to be transparent about our data practices for all users of our website
                            and mobile app, including:</p>

                        <ul>
                            <li>Visitors</li>
                            <li>Shoppers</li>
                            <li>Prospective customers</li>
                            <li>Existing customers</li>
                        </ul>

                        <h2>Scope of this Privacy Policy</h2>
                        <p>This Privacy Policy explains how we collect, store, use, and share personal data from users who:
                        </p>

                        <ul>
                            <li>Access, shop, or interact with our:
                                <ul>
                                    <li>Mobile app ("App")</li>
                                    <li>Websites including <a
                                            href="https://www.magentickphotoframes.com/">https://www.MagentickPhotoFrames.com/</a>
                                    </li>
                                    <li>Blogs, online advertisements, surveys, emails, and other communications managed by
                                        us</li>
                                </ul>
                            </li>
                            <li>Participate in our Referral Program, as described in the Referral Terms.</li>
                        </ul>

                        <h2>1. Data Collection</h2>
                        <p>In this Privacy Policy, "personal data" (or "personal information," as defined under certain laws
                            like the Indian Consumer Privacy Act (CCPA)) refers to any information that identifies, relates
                            to, or could reasonably be linked—directly or indirectly—to an individual or household. This
                            does not include aggregated, de-identified, or anonymized data that cannot be connected to a
                            specific person.</p>

                        <p>Over the past twelve (12) months, we have collected the following categories of personal data:
                        </p>

                        <table>
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Examples</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IDs</td>
                                    <td>Name, mailing address, contact number, email ID</td>
                                </tr>
                                <tr>
                                    <td>Commercial data</td>
                                    <td>Transaction records or usage trends associated with our Services.</td>
                                </tr>
                                <tr>
                                    <td>Internet or Network Activity</td>
                                    <td>Navigation records and engagements with our website, gathered via cookies, tracking
                                        pixels, and log data.</td>
                                </tr>
                                <tr>
                                    <td>Location Data</td>
                                    <td>Generalized location details, such as city or ZIP code inferred from your IP
                                        address.</td>
                                </tr>
                                <tr>
                                    <td>Medias</td>
                                    <td>Images you submit via our Services, along with metadata such as image properties,
                                        detected faces, and objects ("Content Data")</td>
                                </tr>
                            </tbody>
                        </table>

                        <p>If any of this information pertains exclusively to a non-human entity, it is not classified as
                            personal data and is therefore excluded from the scope of this Privacy Policy.</p>
                        <p>We collect personal data from the following sources:</p>
                        <ul>
                            <li><strong>From you:</strong>When you engage with our Services, make purchases, seek
                                information, or reach out to us (via email, chat, etc.), we may collect relevant data. If
                                you connect your MagentickPhotoFrames account to a third-party platform like Facebook or
                                Google, we may access select details and images from those accounts with your consent.
                                Upon installing our App, you have the option to grant access to specific photos or your
                                entire gallery.
                            </li>
                        </ul>
                        <p>We also utilize analytics tools, such as Google Analytics, to gain insights into user
                            interactions with our Services—such as visit frequency, pages viewed, and referral sources
                            (e.g., ads, emails). For more details on Google’s data practices and how to manage your
                            preferences, please refer to Google’s partner site policies.</p>
                        <h2>Data Usages</h2>
                        <p>We process your personal data, as described in Section 1, for the following purposes:</p>
                        <ul>
                            <li><strong>Service Delivery & Enhancement:</strong> Operating our platform, fulfilling orders,
                                and optimizing user experiences.</li>
                            <li><strong>Identity Verification:</strong> Securing account access and preventing unauthorized
                                use.</li>
                            <li><strong>Customer Support:</strong> Addressing inquiries, resolving issues, and providing
                                technical assistance.</li>
                            <li><strong>Personalization:</strong> Tailoring our Services based on your preferences and
                                feedback.</li>
                            <li><strong>Communication:</strong> Sending service-related updates (e.g., password resets,
                                billing notifications) and promotional content (e.g., newsletters, special offers).</li>
                            <li><strong>Security & Fraud Prevention:</strong> Detecting and mitigating fraud, errors, and
                                unlawful activities.</li>
                            <li><strong>Regulatory Compliance:</strong> Adhering to legal requirements and contractual
                                obligations.</li>
                        </ul>

                        <h2>Processing under legal guidance</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Purpose</th>
                                    <th>Legal Basis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Service delivery and enhancement</td>
                                    <td>Performance of a contract, Legitimate interests</td>
                                </tr>
                                <tr>
                                    <td>Identity verification</td>
                                    <td>Legitimate interests, Performance of a contract</td>
                                </tr>
                                <tr>
                                    <td>Customer support</td>
                                    <td>Legitimate interests, Performance of a contract</td>
                                </tr>
                                <tr>
                                    <td>Service personalization</td>
                                    <td>Performance of a contract, Consent, Legitimate interests</td>
                                </tr>
                                <tr>
                                    <td>Image cropping (using facial recognition)</td>
                                    <td>Performance of a contract, Consent</td>
                                </tr>
                                <tr>
                                    <td>Service-related and promotional communication</td>
                                    <td>Performance of a contract, Legitimate interests, Consent</td>
                                </tr>
                                <tr>
                                    <td>Security measures</td>
                                    <td>Performance of a contract, Legitimate interests, Legal obligations</td>
                                </tr>
                                <tr>
                                    <td>Data insights and analytics</td>
                                    <td>Legitimate interests</td>
                                </tr>
                                <tr>
                                    <td>Legal and regulatory compliance</td>
                                    <td>Performance of a contract, Legitimate interests, Legal obligations</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2>Data Retention Policy</h2>
                        <p class="highlight">We retain your personal data only for as long as necessary to:</p>
                        <ul>
                            <li>Deliver and enhance our Services</li>
                            <li>Comply with legal and contractual obligations</li>
                            <li>Resolve disputes and maintain required records</li>
                        </ul>

                        <h3>Retention Considerations</h3>
                        <p>Our data retention decisions are based on factors such as data sensitivity, potential risks,
                            processing requirements, and applicable legal regulations.</p>

                        <h3>Image Retention</h3>
                        <ul>
                            <li>Uploaded images remain stored until your account is deleted.</li>
                            <li>Unprinted images (not selected for tiles) are automatically deleted 30 days after
                                upload.</li>
                            <li>You may request the deletion of your images or personal data by contacting us at <a
                                    href="mailto:support@MagentickPhotoFrames.com">support@MagentickPhotoFrames.com</a>.</li>
                        </ul>

                        <h3>Payment Information</h3>
                        <ul>
                            <li>We do not store payment details.</li>
                            <li>Payment information is securely processed by our Service Providers.</li>
                        </ul>

                        <p>We reserve the right to securely delete your data at any time, with or without notice, unless
                            legally required otherwise.</p>

                        <p>We may share your personal data in the following circumstances:</p>

                        <h2>1. Legal Compliance</h2>
                        <p>We may disclose your information to government agencies or law enforcement authorities if
                            required by law (e.g., subpoenas, search warrants) or when necessary to:</p>
                        <ul>
                            <li>Fulfill legal obligations.</li>
                            <li>Investigate or prevent fraud, illegal activities, or security threats.</li>
                            <li>Protect MagentickPhotoFrames' rights, services, and the safety of users.
                            </li>
                        </ul>

                        <h2>2. Service Providers</h2>
                        <p>We collaborate with trusted third-party partners who assist in:</p>
                        <ul>
                            <li>Manufacturing and shipping</li>
                            <li>Payment processing</li>
                            <li>IT support and security</li>
                            <li>Marketing and customer support</li>
                        </ul>
                        <p>These Service Providers are granted access to your data only to perform their services on our
                            behalf.</p>

                        <h2>3. Public Feedback & Reviews</h2>
                        <p>If you submit a public review or testimonial, we may display it on our platform. To request
                            removal, contact <a href="mailto:support@MagentickPhotoFrames.com"
                                class="contact-link">support@MagentickPhotoFrames.com</a>.</p>

                        <h2>4. Protecting Rights & Safety</h2>
                        <p>We may share your data if we believe it is necessary to safeguard MagentickPhotoFrames, our users,
                            or the public from harm.</p>

                        <p>For any inquiries regarding data sharing, contact <a
                                href="mailto:support@MagentickPhotoFrames.com"
                                class="contact-link">support@MagentickPhotoFrames.com</a>.</p>

                        <h2>5. Communication Preferences</h2>
                        <p>We may contact you for various reasons:</p>

                        <h3>1. Service Updates (Essential Communications)</h3>
                        <p>These include important notifications about:</p>
                        <ul>
                            <li>Orders, shipping, and billing.</li>
                            <li>Changes to our services.</li>
                        </ul>
                        <p>These messages are <span class="mandatory">mandatory</span> and cannot be opted out of.</p>

                        <h3>2. Promotional Messages</h3>
                        <p>These include:</p>
                        <ul>
                            <li>Special offers, discounts, or new features.</li>
                            <li>Reminders (e.g., abandoned carts or personalized recommendations).</li>
                        </ul>
                        <p>You can opt out of promotional messages by:</p>
                        <ul>
                            <li>Clicking "unsubscribe" in an email.</li>
                            <li>Contacting us at <a href="mailto:support@MagentickPhotoFrames.com"
                                    class="contact-link">support@MagentickPhotoFrames.com</a>.</li>
                        </ul>

                        <h2>6. How We Protect Your Data</h2>
                        <div class="security-block">
                            <p>We implement industry-standard security measures, including:</p>
                            <ul>
                                <li><span>Data encryption</span> to protect information in transit and at
                                    rest.</li>
                                <li><span>Access controls</span> to limit unauthorized data access.</li>
                                <li><span>Secure systems</span> to prevent theft, loss, or misuse.</li>
                            </ul>
                            <p>While we take security seriously, no system is <span>100% secure</span>. We
                                continuously monitor and update our safeguards but cannot guarantee absolute protection.</p>
                        </div>

                        <h2>Updates & Amendments</h2>
                        <div>
                            <p>We may periodically update this Privacy Policy by publishing a revised version on our
                                Services. The updated policy will take effect on the date of publication. If significant
                                changes are made, we will notify you in advance via appropriate communication channels or
                                directly through our Services.</p>
                            <p>Your continued use of our Services after the notice period constitutes acceptance of the
                                revised terms.</p>
                        </div>

                        <h2>Compliance with Indian Privacy Laws</h2>
                        <p>This Privacy Policy explains:</p>
                        <ul>
                            <li>The types of personal information we collect (<span>Section 1</span>)</li>
                            <li>Its sources</li>
                            <li>Our data retention (<span>Section 4</span>) and deletion practices (<span>Section 9</span>)
                            </li>
                            <li>How we process your data (<span>Sections 1-7</span>), including for business purposes under
                                the CCPA</li>
                        </ul>

                        <h2>Children's Privacy</h2>
                        <p>Our Services are not intended for children under 16 years old. We do not knowingly collect their
                            personal data.</p>
                        <p>If we discover a child is using our Services, we will:</p>
                        <ul>
                            <li>Restrict access</li>
                            <li>Delete any collected personal data</li>
                        </ul>
                        <p>If you suspect we hold such data, contact <a href="mailto:support@MagentickPhotoFrames.com"
                                class="contact-link">support@MagentickPhotoFrames.com</a>.</p>

                        <h2>Questions, Concerns, or Complaints</h2>
                        <p>For any questions, concerns, or complaints regarding this Privacy Policy or how
                            MagentickPhotoFrames processes your data, contact us at <a
                                href="mailto:support@MagentickPhotoFrames.com"
                                class="contact-link">support@MagentickPhotoFrames.com</a>.</p>

                        <div>📅 Last updated: MAY 2025</div>

                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
@endpush
