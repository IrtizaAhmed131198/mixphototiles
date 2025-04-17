@extends('components.layouts.app')

@section('title', 'Terms and Conditions')

@push('css')
    <style>
        .child-terms {
            margin: auto;
            width: 70%;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .child-terms h1 {
            color: black;
            text-align: start !important;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 35px;
        }

        .child-terms p {
            color: black;
            font-weight: 400;
            font-size: 15px;
            line-height: 25px;
        }

        .child-terms ul li {
            margin-bottom: 10px;
            list-style: number;
        }

        .child-terms h2 {
            color: black;
            font-weight: 500;
            font-size: 30px;
            margin: 30px 0;
        }

        .child-terms table {
            margin: 40px 0;
        }

        .child-terms table tr th {
            color: black;
            font-size: 16px;
            padding-bottom: 20px !important;
        }

        .child-terms table tr td {
            padding-bottom: 15px;
        }

        .child-terms ul li strong {
            color: black;
        }

        .child-terms ul li ul li {
            list-style: none;
            position: relative;
            z-index: 0;
        }

        .child-terms ul li ul li:before {
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

        .child-terms ul li ul {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <section class="terms-policy">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="child-terms">
                        <h1 class="text-center">MagneticPhotoFrames Terms of Service</h1>

                          <p><span><span><span>We encourage you to read our full Terms of Service below, as they govern
                                  your use of MagneticPhotoFrames. But if you&#39;re looking for key takeaways, here are the most important
                                  points:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Image Ownership: </b>You retain full
                                      copyright to the photos you upload. We do not sell, share, or use them for anything other than printing and
                                      delivering your tiles.</span></span></span></span></li>
                            <li><span><span><span><span><b>Data Deletion: </b>If you&rsquo;d like
                                      us to delete your photos and personal data from our system, simply email us at
                                      support@MagneticPhotoFrames.com using the same email address you used for your
                                      order.</span></span></span></span></li>
                            <li><span><span><span><span><b>Content Restrictions: </b>You may only
                                      upload images you own. We do not print pornography, discriminatory content, or copyrighted images you do not
                                      have rights to. If unauthorized content leads to legal claims, you will be responsible for all related
                                      costs.</span></span></span></span></li>
                            <li><span><span><span><span><b>Customer Support: </b>If you experience
                                      any issues with your order, contact us via email at support@MagneticPhotoFrames.com
                                    </span></span></span></span></li>
                          </ul>

                          <p><span><span><span>For full details, please review our complete Terms of Service
                                  below.</span></span></span></p>

                          <p><span><span><span><u>The&nbsp;Actual Terms of Service</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>MagneticPhotoFrames (&quot;we,&quot;
                                      &quot;us,&quot; or &quot;our&quot;) provides users with the ability to upload images (&quot;Images&quot;)
                                      via our website (&quot;Site&quot;) </span></span></span></span></li>
                            <li><span><span><span><span>Print these Images on wall tiles
                                      (&quot;Tiles&quot;), or</span></span></span></span></li>
                            <li><span><span><span><span>Purchase our &ldquo;Moments by
                                      MagneticPhotoFrames&rdquo; product offering (&quot;Moments&quot;).</span></span></span></span></li>
                            <li><span><span><span><span>Together, these are referred to as the
                                      <b>&quot;Products.&quot;</b></span></span></span></span></li>
                            <li><span><span><span><span>These <b>Terms of Service
                                        (&quot;Terms&quot;)</b> govern your access to and use of the App and related services
                                      (&quot;Services&quot;). Our <b>Privacy Notice</b>&nbsp; outlines how we collect, process, and transfer
                                      personal data.</span></span></span></span></li>
                            <li><span><span><span><span><b>&quot;You&quot;</b> refers to any adult
                                      user of the App or Services, or a parent/guardian responsible for a minor using the App or
                                      Services.</span></span></span></span></li>
                            <li><span><span><span><span>By clicking <b>&quot;I agree,&quot;</b>
                                      you confirm your acceptance of these Terms. We may update these Terms periodically. If you do not agree,
                                      please refrain from using the App or Services.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><b>Arbitration Agreement</b></span></span></span></p>

                          <p><span><span><span><b>Filing an Arbitration Claim</b></span></span></span></p>

                          <p><span><span><span>To initiate arbitration:</span></span></span></p>

                          <ol>
                            <li><span><span><span><span>Send a <b>written Notice of Claim</b> via
                                      email to <b>support@MagneticPhotoFrames.com</b> with the subject line <b>&ldquo;LEGAL
                                        NOTICE.&rdquo;</b></span></span></span></span></li>
                            <li><span><span><span><span>The Notice must include:
                                    </span></span></span></span>
                              <ul>
                                <li><span><span><span><span>A description of the
                                          dispute</span></span></span></span></li>
                                <li><span><span><span><span>The specific relief
                                          sought</span></span></span></span></li>
                              </ul>
                            </li>
                            <li><span><span><span><span>If no resolution is reached within <b>60
                                        days</b>, either party may proceed with arbitration or file a claim in <b>small claims court (if
                                        eligible).</b></span></span></span></span></li>
                          </ol>

                          <p>&nbsp;</p>

                          <p><span><span><span><b>Arbitration Process &amp; Governing Law</b></span></span></span></p>

                          <p><span><span><span><b>Class Action Waiver</b></span></span></span></p>

                          <p><span><span><span><b>You and MagneticPhotoFrames agree that claims may only be brought in an
                                    individual capacity, not as part of any class, collective, or representative action.</b> The arbitrator
                                  <b>cannot</b> consolidate claims or preside over class/representative proceedings.</span></span></span></p>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Use of the Services</u></span></span></span></p>

                          <p><span><span><span><b>Eligibility &amp; Compliance</b></span></span></span></p>

                          <p><span><span><span>By using the MagneticPhotoFrames and Services, you confirm
                                  that:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span>All information you provide is <b>truthful
                                        and accurate</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You are <b>18 years or older</b>, or have
                                      <b>parental/guardian consent</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You have the <b>legal capacity to enter
                                        into a binding contract</b>.</span></span></span></span></li>
                            <li><span><span><span><span>Your use of the App and Services
                                      <b>complies with all applicable laws and regulations</b>.</span></span></span></span></li>
                            <li><span><span><span><span>If uploading images of minors, you have
                                      <b>obtained parental consent</b> before sharing any data.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Sensitive Data &amp; Privacy Compliance</b></span></span></span></p>

                          <p><span><span><span>Certain types of data require special protection. You
                                  agree:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Not to upload</b> any images containing
                                      <b>Sensitive Data</b> (e.g., racial origin, religious beliefs, health, or children&#39;s data) unless you
                                      have obtained <b>explicit legal consent</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You are <b>solely responsible</b> for any
                                      liability related to Sensitive Data, including potential data breaches.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>App Functionality &amp; Changes</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>MagneticPhotoFrames may update, modify, or
                                      discontinue parts of the Services <b>without affecting existing orders</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You may <b>link third-party accounts</b>
                                      (e.g., Facebook, Google Photos, Instagram) to the site, ensuring you have the <b>authority to grant
                                        access</b> to stored images.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>User Security &amp; Account Responsibility</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You are fully responsible for <b>securing
                                        your devices</b> and ensuring proper use of the App.</span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames <b>cannot monitor or
                                        prevent</b> inappropriate use of the App.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Service Refusal &amp; Account Termination</b></span></span></span></p>

                          <p><span><span><span>MagneticPhotoFrames <b>reserves the right</b> to suspend or terminate
                                  access to the App/Services <b>without prior notice</b> if:</span></span></span></p>

                          <p><span><span><span>You violate these <b>Terms</b>.</span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You engage in <b>fraudulent, harassing, or
                                        illegal activity</b>.</span></span></span></span></li>
                            <li><span><span><span><span>Your behavior is harmful to <b>other
                                        users, third parties, or MagneticPhotoFrames&rsquo; business</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You <b>dispute or chargeback payments</b>
                                      made to MagneticPhotoFrames.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Legal Compliance &amp; Enforcement</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>MagneticPhotoFrames may <b>take corrective
                                        action</b> against violations, including cooperating with <b>law enforcement</b> or legal
                                      authorities.</span></span></span></span></li>
                            <li><span><span><span><span><b>Suspension or termination</b> of your
                                      account does not waive your obligations, including <b>ownership rights, indemnification, liability
                                        limitations, or payment responsibilities</b>.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Account Registration</u></span></span></span></p>

                          <p><span><span><span><b>Account Registration &amp; Access</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You <b>may</b> register for an account
                                      (<b>&quot;Account&quot;</b>) to purchase Tiles and <b>must</b> register for an Account to subscribe to
                                      <b>Moments</b>.</span></span></span></span></li>
                            <li><span><span><span><span>Accounts can be created using <b>Facebook,
                                        Google, or email</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Login security:</b> You will receive a
                                      <b>one-time unique passcode</b> for each login session.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Account Security &amp; User Responsibilities</b></span></span></span>
                          </p>

                          <ul>
                            <li><span><span><span><span>Provide <b>accurate, complete, and
                                        updated</b> information.</span></span></span></span></li>
                            <li><span><span><span><span>Maintain <b>confidentiality</b> of your
                                      Account details and <b>secure your devices</b> (computers, smartphones,
                                      tablets).</span></span></span></span></li>
                            <li><span><span><span><span>You <b>must not</b>:
                                    </span></span></span></span>
                              <ol>
                                <li><span><span><span><span>Impersonate another person by using
                                          their email as your username.</span></span></span></span></li>
                                <li><span><span><span><span>Use an email owned by someone else
                                          without <b>authorization</b>.</span></span></span></span></li>
                                <li><span><span><span><span>Select a username that is
                                          <b>offensive, vulgar, or obscene</b>.</span></span></span></span></li>
                              </ol>
                            </li>
                            <li><span><span><span><span>You <b>cannot</b> use another
                                      person&rsquo;s Account without their permission.</span></span></span></span></li>
                            <li><span><span><span><span>Notify MagneticPhotoFrames
                                      <b>immediately</b> in case of: </span></span></span></span>
                              <ul>
                                <li><span><span><span><span><b>Security
                                            breaches</b></span></span></span></span></li>
                                <li><span><span><span><span><b>Unauthorized account
                                            access</b></span></span></span></span></li>
                                <li><span><span><span><span><b>Change in eligibility to use the
                                            Services</b></span></span></span></span></li>
                              </ul>
                            </li>
                            <li><span><span><span><span>Do <b>not</b> publish, distribute, or post
                                      your <b>login information</b> publicly.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>User Content &amp; Privacy</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You may need to provide <b>User
                                        Content</b> while using the Services.</span></span></span></span></li>
                            <li><span><span><span><span>You are <b>solely responsible</b> for
                                      ensuring the accuracy and <b>up-to-date</b> nature of your User Content.</span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames handles your data in
                                      accordance with its <b>Privacy Policy</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Warranties &amp; Legal Compliance</b></span></span></span></p>

                          <p><span><span><span>By creating an Account, you confirm that:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You are <b>legally capable</b> of entering
                                      into a contract.</span></span></span></span></li>
                            <li><span><span><span><span>Your <b>registration information is
                                        accurate</b> and will remain updated.</span></span></span></span></li>
                            <li><span><span><span><span>Your <b>use of the Services</b> complies
                                      with all <b>applicable laws and regulations</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Exclusive Account Features &amp; Communications</b></span></span></span>
                          </p>

                          <ul>
                            <li><span><span><span><span>Account holders may <b>access additional
                                        features</b> unavailable to non-Account users.</span></span></span></span></li>
                            <li><span><span><span><span>You <b>may receive</b> promotional emails,
                                      offers, and surveys.</span></span></span></span></li>
                            <li><span><span><span><span>You can <b>unsubscribe</b> from
                                      MagneticPhotoFrames&#39; commercial emails anytime by <b>emailing us.</b></span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Content and User Content</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Definition of Content &amp; User
                                        Content</b></span></span></span></span></li>
                            <li><span><span><span><span><b>&quot;Content&quot;</b> includes all
                                      materials available through the App or Services, such as <b>images, photos, and modifications</b>
                                      thereof.</span></span></span></span></li>
                            <li><span><span><span><span><b>&quot;User Content&quot;</b> refers to
                                      all content uploaded by you, including images, photos, and any <b>Sensitive
                                        Data</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Your Responsibilities &amp; Legal
                                        Compliance</b></span></span></span></span></li>
                            <li><span><span><span><span>You <b>are fully responsible</b> for all
                                      <b>User Content</b> uploaded to the App.</span></span></span></span></li>
                            <li><span><span><span><span><b>You must ensure that your User
                                        Content</b>: </span></span></span></span></li>
                            <li><span><span><span><span><b>Complies with all applicable
                                        laws</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Does not infringe</b> on third-party
                                      <b>intellectual property rights, privacy rights, or moral rights</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Has the necessary legal permissions and
                                        consents</b>, especially when containing <b>Sensitive Data</b> (e.g., explicit consent from the
                                      individual, parent, or guardian).</span></span></span></span></li>
                            <li><span><span><span><span><b>You warrant that you have all required
                                        rights</b> to provide MagneticPhotoFrames with any Sensitive Data <b>for processing under these Terms and
                                        the Privacy Notice</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>MagneticPhotoFrames&rsquo; Rights &amp;
                                        Limitations</b></span></span></span></span></li>
                            <li><span><span><span><span><b>No obligation</b> to accept requests
                                      for <b>printing</b> or <b>storing</b> User Content.</span></span></span></span></li>
                            <li><span><span><span><span><b>Right to remove and delete</b> User
                                      Content <b>without notice</b> for any reason.</span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames <b>does not
                                        endorse</b> any User Content, opinions, or recommendations.</span></span></span></span></li>
                            <li><span><span><span><span><b>Liability disclaimer</b>:
                                      MagneticPhotoFrames <b>is not responsible</b> for actions by other users unless due to its own gross
                                      negligence or willful misconduct.</span></span></span></span></li>
                            <li><span><span><span><span><b>User Content Retention &amp;
                                        Deletion</b></span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames <b>may retain your
                                        User Content</b> (including images) in your <b>order history</b> as long as your Account is
                                      active.</span></span></span></span></li>
                            <li><span><span><span><span>You <b>can request deletion</b> of your
                                      User Content via email, as described in the <b>Privacy Notice</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Unprinted images</b> uploaded to the
                                      App <b>will be automatically deleted after 30 days</b>.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>User Content Restrictions</u></span></span></span></p>

                          <p><span><span><span>By using the App and Services, <b>you agree NOT to upload, submit, or act
                                    in ways that</b>:</span></span></span></p>

                          <p><span><span><span><b>1. Disrupt or Inhibit Use</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Interfere with or <b>restrict other
                                        users</b> from using the App or Services.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>2. Violate Rights or Intellectual Property</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Infringe</b> on any third party&rsquo;s
                                      <b>intellectual property, privacy, publicity, or moral rights</b>.</span></span></span></span></li>
                            <li><span><span><span><span>Violate the <b>legal rights</b> of
                                      others.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>3. Include Illegal or Unauthorized Content</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Contain or promote <b>stolen, counterfeit,
                                        fraudulent, pirated, or unauthorized</b> material.</span></span></span></span></li>
                            <li><span><span><span><span>Involve <b>illegal, violent, or
                                        unauthorized activities</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Fail to comply</b> with all
                                      <b>applicable laws and regulations</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>4. Overload the System</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Impose an <b>unreasonable or excessive
                                        burden</b> on MagneticPhotoFrames&rsquo; infrastructure.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>5. Contain or Link to Harmful or Offensive
                                    Material</b></span></span></span></p>

                          <p><span><span><span>You <b>must not post, store, or transmit anything
                                    containing</b>:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Hate speech</b>, bigotry, or
                                      <b>material glorifying violence</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Racially, ethnically, or culturally
                                        insensitive</b> content.</span></span></span></span></li>
                            <li><span><span><span><span><b>Defamatory, harassing, or
                                        threatening</b> content.</span></span></span></span></li>
                            <li><span><span><span><span><b>Pornography or obscene material</b>,
                                      especially anything <b>depicting children in sexually suggestive situations</b>.</span></span></span></span>
                            </li>
                            <li><span><span><span><span><b>Viruses, worms, Trojan horses</b>, or
                                      other harmful software.</span></span></span></span></li>
                            <li><span><span><span><span><b>Encouragement of criminal behavior</b>
                                      or violations of the law.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span>MagneticPhotoFrames reserves the right to <b>remove any content that
                                    violates these guidelines</b> without notice.</span></span></span></p>

                          <p><span><span><span><u>Use Restrictions</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You <b>must not</b> engage in or attempt
                                      any of the following actions, nor assist a third party in doing so:</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>1. Reverse Engineering &amp; Unauthorized
                                    Access</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Decipher, decompile, disassemble, or
                                        reverse-engineer</b> any software, technology, or product used in the App or
                                      Services.</span></span></span></span></li>
                            <li><span><span><span><span><b>Frame or mirror</b> any part of the App
                                      without <b>prior written authorization</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>2. Security Violations</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Bypass, disable, or interfere</b> with
                                      security features, including those that <b>prevent copying or unauthorized use</b> of
                                      content.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>3. Unauthorized Commercial Use</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Use the site, Content, or Services for
                                      <b>commercial purposes</b> outside the scope permitted in these Terms.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>4. Automated Data Collection &amp; Scraping</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Use <b>bots, spiders, scrapers, or
                                        automated tools</b> to <b>retrieve, index, data-mine, or replicate
                                        content</b>.</span></span></span></span></li>
                            <li><span><span><span><span>Attempt to <b>circumvent the App&rsquo;s
                                        structure or navigation</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>5. Violating Terms of Use</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Engage in <b>any use of the App, Content,
                                        or Services that contradicts these Terms</b>.</span></span></span></span></li>
                            <li><span><span><span><span>Violating any of these restrictions may
                                      result in <b>account suspension, termination, and legal action</b>.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Intellectual Property</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Ownership of the App &amp;
                                        Services</b></span></span></span></span></li>
                            <li><span><span><span><span><b>MagneticPhotoFrames</b>, its
                                      <b>affiliates</b>, and <b>licensors</b> <b>own all rights</b> to the App, Services, trademarks, logos, and
                                      related intellectual property.</span></span></span></span></li>
                            <li><span><span><span><span>You <b>cannot copy, modify, distribute, or
                                        transmit</b> any part of the App or Services <b>without explicit
                                        permission</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>No rights are granted</b> to use
                                      MagneticPhotoFrames&#39; trademarks, service marks, or logos.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>2. Ownership of Uploaded Images</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>You retain full ownership</b> of any
                                      Images or content you upload.</span></span></span></span></li>
                            <li><span><span><span><span><b>MagneticPhotoFrames will only use your
                                        Images</b> to provide the Services and fulfill your product orders.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>3. License Granted to MagneticPhotoFrames</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>By uploading User Content, you grant
                                      MagneticPhotoFrames to <b>use, copy, and print</b> your Images <b>only</b> for producing your ordered
                                      products.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Copyright</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>The policy of MagneticPhotoFrames is not
                                      to infringe upon or violate the intellectual property rights or other rights of any third party, and
                                      MagneticPhotoFrames will refuse to use and remove any User Content in connection with the App that infringes
                                      the rights of any third party. Under the Digital Millennium Copyright Act of 1998
                                      (the&nbsp;<b>&quot;DMCA&quot;</b>), MagneticPhotoFrames will remove any Content (including without
                                      limitation any User Content) if properly notified of that such material infringes third party rights, and
                                      may do so at its sole discretion, without prior notice to users at any time. The policy of
                                      MagneticPhotoFrames is to terminate the Accounts of repeat infringers in appropriate
                                      circumstances.</span></span></span></span></li>
                            <li><span><span><span><span>You are in the best position to judge
                                      whether User Content is in violation of intellectual property or personal rights of any third-party. You
                                      accept full responsibility for avoiding infringement of the intellectual property or personal rights of
                                      others in connection with User Content.</span></span></span></span></li>
                            <li><span><span><span><span>If you believe that something appearing on
                                      the App infringes your copyright, you may send us a notice requesting that it be removed, or access to it
                                      blocked. If you believe that such a notice has been wrongly filed against you, the DMCA lets you send us a
                                      counter-notice. Notices and counter-notices must meet the DMCA&rsquo;s requirements. We suggest that you
                                      consult your legal advisor before filing a notice or counter-notice. Be aware that there can be substantial
                                      penalties for false claims. Send notices and counter-notices to us by contacting&nbsp;<a
                                        href="mailto:hi@mixtiles.com">support@MagneticPhotoFrames.com</a>.</span></span></span></span>
                            </li>
                          </ul>

                          <p><span><span><span><u>Fees and Payment</u></span></span></span></p>

                          <p><span><span><span><b>Payment Information</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>To purchase products, you must provide
                                      billing details like <b>name, billing address, and credit card information</b>.</span></span></span></span>
                            </li>
                            <li><span><span><span><span>Payments are processed either <b>directly
                                        by MagneticPhotoFrames</b> or via a <b>third-party payment processor</b> (&quot;Payment
                                      Processor&quot;).</span></span></span></span></li>
                            <li><span><span><span><span>You must <b>update payment details</b>
                                      promptly to avoid service interruptions.</span></span></span></span></li>
                            <li><span><span><span><span>Credit card issuers may automatically
                                      update your card details to prevent service disruptions (you can opt out by contacting your
                                      issuer).</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>2. Payment Responsibility</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Fees are charged as per the <b>prices
                                        displayed in the App</b> during the purchase process.</span></span></span></span></li>
                            <li><span><span><span><span>Your <b>order is confirmed only after
                                        payment is successfully processed</b>.</span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames is <b>not liable for
                                        any banking fees</b> incurred due to payments.</span></span></span></span></li>
                            <li><span><span><span><span>If your payment method fails, you <b>must
                                        pay the outstanding amount on demand</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You are <b>responsible for taxes and
                                        fees</b> on all purchases.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>3. Payment Processing &amp; Errors</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Payments may be processed <b>via
                                        third-party services</b>, and you must <b>review their terms and privacy policies</b> before using
                                      them.</span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames <b>is not
                                        responsible</b> for errors made by Payment Processors but reserves the right to <b>correct any
                                        mistakes</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>4. Refund Policy</b></span></span></span></p>

                          <p><span><span><span><b>All fees are non-refundable unless explicitly stated
                                    otherwise</b>.</span></span></span></p>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Cancellation of Services&nbsp;</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Cancellation
                                        Policy</b></span></span></span></span></li>
                            <li><span><span><span><span>If you <b>purchased a subscription via a
                                        third-party app provider</b>, you must <b>cancel it through that provider</b> following their cancellation
                                      policies.</span></span></span></span></li>
                            <li><span><span><span><span>If you <b>purchased through the
                                        MagneticPhotoFrames site</b>, you can cancel your <b>monthly or annual subscription</b> at any time by:
                                    </span></span></span></span></li>
                            <li><span><span><span><span><b>Emailing</b>:
                                      support@MagneticPhotoFrames.com</span></span></span></span></li>
                            <li><span><span><span><span><b>No refunds</b> are provided for the
                                      current subscription period, but you will continue receiving services until the end of your paid
                                      period.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>2. Suspension &amp; Termination</b></span></span></span></p>

                          <p><span><span><span>MagneticPhotoFrames <b>reserves the right to suspend or terminate</b> your
                                  access to Products &amp; Services <b>without notice</b> if: </span></span></span></p>

                          <ul>
                            <li><span><span><span><span>You <b>commit
                                        fraud</b>.</span></span></span></span></li>
                            <li><span><span><span><span>You <b>breach any obligation</b> under
                                      these Terms.</span></span></span></span></li>
                            <li><span><span><span><span>You <b>attempt to copy, resell, or
                                        distribute</b> MagneticPhotoFrames Products without authorization.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Refunds</u></span></span></span></p>

                          <p><span><span><span>We want you to be completely satisfied with your
                                  Product(s).</span></span></span></p>

                          <p><span><span><span><b>Eligibility for a Refund</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>If MagneticPhotoFrames made a
                                        mistake</b> in preparing your order or your Product(s) <b>arrived damaged</b>, we will <b>gladly issue a
                                        refund</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>If you made a mistake in ordering</b>
                                      or simply <b>changed your mind</b>, your order <b>may not be eligible for a
                                        refund</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>How to Request a Refund</b></span></span></span></p>

                          <p><span><span><span>To request a refund, contact us through one of the
                                  following:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Email</b>:
                                      support@MagneticPhotoFrames.com</span></span></span></span></li>
                          </ul>

                          <p><span><span><span>For orders with <b>printing errors or damage</b>, please include a
                                  <b>picture of the Product(s)</b> with your request to help us process your refund
                                  efficiently.</span></span></span></p>

                          <p>&nbsp;</p>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Third Party Applications and Services</u></span></span></span></p>

                          <p><span><span><span>Some portions of the <b>MagneticPhotoFrames App and Services</b> may
                                  include links to <b>third-party websites or mobile applications</b>. These links may direct you to
                                  <b>third-party vendors</b> for various services, including reviews or purchases.</span></span></span></p>

                          <p><span><span><span><b>Important Considerations</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>MagneticPhotoFrames has no control</b>
                                      over third-party websites, apps, or services.</span></span></span></span></li>
                            <li><span><span><span><span><b>Use of third-party sites is at your own
                                        risk</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>We are not responsible</b> for:
                                    </span></span></span></span>
                              <ul>
                                <li><span><span><span><span>Any <b>payments processed</b> through
                                          third-party platforms.</span></span></span></span></li>
                                <li><span><span><span><span>The <b>privacy policies</b> of
                                          third-party sites.</span></span></span></span></li>
                                <li><span><span><span><span>The <b>content or services</b> offered
                                          by third parties.</span></span></span></span></li>
                              </ul>
                            </li>
                          </ul>

                          <p><span><span><span><b>Disclaimer</b></span></span></span></p>

                          <p><span><span><span>MagneticPhotoFrames <b>does not endorse</b> or take responsibility for any
                                  <b>third-party products or services</b>. We encourage users to <b>exercise caution</b> when interacting with
                                  external websites or applications.</span></span></span></p>

                          <p>&nbsp;</p>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Disclaimers and Disclaimer of Warranty</u></span></span></span></p>

                          <p><span><span><span>Your use of the <b>MagneticPhotoFrames App, Services, and Products</b> is
                                  entirely <b>at your own risk</b>. The App, its content (including User Content), Services, and Products are
                                  provided <b>&quot;AS IS&quot; and &quot;AS AVAILABLE&quot;</b> without any warranties.</span></span></span></p>

                          <p><span><span><span><b>No Guarantees on Product Quality or Usefulness</b></span></span></span>
                          </p>

                          <ul>
                            <li><span><span><span><span>We <b>strive</b> to print Images <b>as
                                        accurately as possible</b>, but we <b>do not guarantee</b> an exact match.</span></span></span></span>
                            </li>
                            <li><span><span><span><span>We <b>do not warrant</b> that Products
                                      will meet your specific needs or expectations.</span></span></span></span></li>
                            <li><span><span><span><span>We <b>are not responsible</b> for:
                                    </span></span></span></span>
                              <ul>
                                <li><span><span><span><span>The <b>quality, condition, or
                                            usability</b> of the Products.</span></span></span></span></li>
                                <li><span><span><span><span>Any <b>damage occurring during
                                            transportation</b>.</span></span></span></span></li>
                                <li><span><span><span><span>Issues arising from <b>attaching,
                                            sticking, or re-sticking</b> the Products to any surface.</span></span></span></span></li>
                              </ul>
                            </li>
                          </ul>

                          <p><span><span><span><b>Disclaimer of All Warranties</b></span></span></span></p>

                          <p><span><span><span>To the fullest extent permitted by law, <b>MagneticPhotoFrames expressly
                                    disclaims</b> all warranties, including but not limited to:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Merchantability, fitness for a
                                        particular purpose, and non-infringement</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Security, accuracy, reliability, and
                                        performance</b> of the App and Services.</span></span></span></span></li>
                            <li><span><span><span><span><b>Error-free operation</b> or the
                                      correction of any errors.</span></span></span></span></li>
                            <li><span><span><span><span><b>Accuracy, quality, or usefulness of any
                                        information</b> provided.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Limitation of Liability</b></span></span></span></p>

                          <p><span><span><span>MagneticPhotoFrames <b>is not responsible</b> for:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span>Any <b>physical damage</b> caused by the
                                      use of the Products.</span></span></span></span></li>
                            <li><span><span><span><span>Any <b>damages</b> resulting from
                                      attachment, detachment, or re-sticking of the Products.</span></span></span></span></li>
                            <li><span><span><span><span>Any <b>reliance on oral or written
                                        advice</b> not explicitly stated in these Terms.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Note:</b> Some jurisdictions <b>do not allow</b> the exclusion of
                                  certain warranties. In such cases, these disclaimers <b>may not apply to you</b>. Please check your local
                                  laws.</span></span></span></p>

                          <p>&nbsp;</p>

                          <p>&nbsp;</p>

                          <ul>
                            <li><span><span><span><span><u>Limitation of
                                        Liability</u></span></span></span></span></li>
                          </ul>

                          <p><span><span><span>MagneticPhotoFrames <b>assumes no responsibility</b> for any technical
                                  issues, errors, or malfunctions, including but not limited to:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Delays, defects, interruptions, or
                                        failures</b> in operation or transmission.</span></span></span></span></li>
                            <li><span><span><span><span><b>Theft, unauthorized access, or data
                                        alterations</b> related to Content or Services.</span></span></span></span></li>
                            <li><span><span><span><span><b>Product attachment/detachment
                                        issues</b> or the <b>quality of the printed image</b> on the Product(s).</span></span></span></span></li>
                            <li><span><span><span><span><b>Network failures, server issues, or
                                        software malfunctions</b> affecting the App or Services.</span></span></span></span></li>
                            <li><span><span><span><span><b>Email failures, internet traffic
                                        congestion, or technical issues</b> causing service disruptions.</span></span></span></span></li>
                            <li><span><span><span><span><b>Damage to devices</b> (e.g., phones,
                                      computers) due to App or Service usage, including uploading/downloading images.</span></span></span></span>
                            </li>
                          </ul>

                          <p><span><span><span><b>No Responsibility for Loss or Damage</b></span></span></span></p>

                          <p><span><span><span>MagneticPhotoFrames <b>is not responsible</b> for:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Personal injury or death</b> resulting
                                      from use of the App, Services, or Products.</span></span></span></span></li>
                            <li><span><span><span><span><b>Content posted through the App or
                                        Services</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>User conduct</b>, whether online or
                                      offline.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Exclusion of Damages</b></span></span></span></p>

                          <p><span><span><span>To the <b>fullest extent permitted by law</b>, MagneticPhotoFrames,
                                  including its <b>officers, directors, employees, assignees, and agents</b>, <b>shall not be liable</b> for
                                  any:</span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Indirect, incidental, special,
                                        punitive, or consequential damages</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Losses arising from the quality,
                                        accuracy, or utility of Products</b> provided through the App or Services.</span></span></span></span>
                            </li>
                            <li><span><span><span><span><b>Foreseeable or unforeseeable
                                        damages</b>, even if we were advised of their possibility.</span></span></span></span></li>
                          </ul>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Indemnification</u></span></span></span></p>

                          <p><span><span><span>You <b>agree to indemnify, defend, and hold harmless</b>
                                  MagneticPhotoFrames and its <b>employees, directors, officers, subcontractors, and agents</b> from <b>any and
                                    all claims, damages, costs, or expenses</b> (including court costs and attorneys&rsquo; fees) arising directly
                                  or indirectly from:</span></span></span></p>

                          <ol>
                            <li><span><span><span><span><b>Breach of Terms</b> &ndash; Any
                                      violation of these Terms by you or <b>anyone using your device</b>, whether authorized or
                                      unauthorized.</span></span></span></span></li>
                            <li><span><span><span><span><b>Use of the App/Services</b> &ndash; Any
                                      claim, loss, or damage resulting from your use or attempted use of the <b>App, Services, or uploaded
                                        Images</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Violation of Laws/Regulations</b>
                                      &ndash; Any non-compliance with applicable laws, regulations, or obligations stated in these
                                      Terms.</span></span></span></span></li>
                            <li><span><span><span><span><b>Third-Party Rights Infringement</b>
                                      &ndash; Any claim that your <b>actions, content, or uploaded Images</b> infringe on <b>third-party
                                        rights</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Any Other Legal Responsibilities</b>
                                      &ndash; Any other matter <b>you are legally responsible for</b> under these Terms or applicable
                                      law.</span></span></span></span></li>
                          </ol>

                          <p><span><span><span>By agreeing to these Terms, you take <b>full responsibility</b> for any
                                  legal consequences arising from your use of MagneticPhotoFrames&#39; <b>App, Services, or
                                    Products</b>.</span></span></span></p>

                          <p>&nbsp;</p>

                          <p>&nbsp;</p>

                          <p><span><span><span><u>Applicable Law; Miscellaneous</u></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>MagneticPhotoFrames <b>does not
                                        guarantee</b> that its <b>Site, App, Services, or Products</b> are appropriate or legally accessible in
                                      all regions.</span></span></span></span></li>
                            <li><span><span><span><span>If you access the <b>Site/App</b>, you do
                                      so <b>at your own risk</b> and are responsible for complying with <b>local
                                        laws</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Legal Disputes &amp; Arbitration</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span><b>Governing Law</b>: Any claims regarding
                                      the <b>Site, App, Services, or Products</b> shall be governed by the <b>laws of the India</b>, <b>excluding
                                        conflict of law principles</b>.</span></span></span></span></li>
                            <li><span><span><span><span><b>Final Judgment</b>: Any final
                                      arbitration ruling shall be enforceable in other jurisdictions as permitted by <b>applicable
                                        law</b>.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>General Terms</b></span></span></span></p>

                          <ul>
                            <li><span><span><span><span>If <b>any provision</b> of these Terms is
                                      found <b>unenforceable</b>, it will be <b>replaced</b> with a valid provision that best reflects the
                                      original intent.</span></span></span></span></li>
                            <li><span><span><span><span>These Terms <b>do not</b> create any
                                      <b>agency, employment, joint venture, or partnership</b> between you and
                                      MagneticPhotoFrames.</span></span></span></span></li>
                            <li><span><span><span><span>These Terms <b>represent the entire
                                        agreement</b> between you and MagneticPhotoFrames and <b>override any prior
                                        agreements</b>.</span></span></span></span></li>
                            <li><span><span><span><span>MagneticPhotoFrames <b>may assign its
                                        rights</b> under these Terms <b>without notice</b>, but <b>you may not assign your rights</b> without
                                      approval.</span></span></span></span></li>
                            <li><span><span><span><span>If MagneticPhotoFrames <b>does not enforce
                                        a provision</b>, it does <b>not waive</b> the right to enforce it in the
                                      future.</span></span></span></span></li>
                            <li><span><span><span><span>Notices from MagneticPhotoFrames will be
                                      sent to the <b>contact information</b> you provided during registration.</span></span></span></span></li>
                          </ul>

                          <p><span><span><span><b>Last Updated: March 2025</b></span></span></span></p>

                          <p>&nbsp;</p>

                          <p>&nbsp;</p>

                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
@endpush
