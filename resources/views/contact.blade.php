@extends('components.layouts.app')

@section('title', 'Contact Us')

@push('css')
<style>
.contact-title {
    max-width: 550px;
    font-size: 60px;
    font-weight: 600;
    line-height: 1.25;
}

.contact-us-section {
    padding-top: 5.25rem;
    padding-bottom: 5.25rem;
}

.contact-info h2 {
    font-size: 18px;
    font-weight: 600;
    line-height: 1.25;
}

.contact-info address {
    max-width: 480px;
    font-size: 18px;
    font-style: normal;
}

.contact-info-2 h2 {
    font-size: 18px;
    font-weight: 600;
    line-height: 1.25;
}

.contact-info-2 a {
    transition: all .3s ease-in-out;
    color: #ff0168 !important;
    opacity: 1;
    text-decoration: none;
    font-size: 28px;
    font-weight: 600;
    line-height: 1.25;
}

.contact-info-2 a:hover {
    color: #000000 !important;
}

.contact-form input, .contact-form textarea {
    padding: 1rem 1.25rem !important;
    line-height: 1.3125 !important;
    border-radius: 0 !important;
    background-clip: padding-box !important;
}

.contact-btn {
    padding: 22px !important;
}

.contact0-map {
    padding-top: 5.5rem;
    padding-bottom: 5.5rem;
}

.contact-map-child {
    background-color: #e5e3df;
}

.contact-map-child iframe {
    width: 100%;
    height: 366px;
    border: 0;
}
</style>
@endpush

@section('content')
<section class="contact-us-section">
    <div class="container">
       <div class="row align-items-end flex-column-reverse flex-md-row">
          <div class="col-md-7 mb-md-auto">
             <h1 class="ttl-60 mb-4 d-none d-md-block contact-title">Got questions? We've got answers let's chat!</h1>
             <div class="ContactInfo_contactInfoWrp__wBllg">
                {{-- <div class="contact-info py-4 mb-md-3">
                   <h2 class="ttl-18 mb-3">Address:</h2>
                   <address class="mb-0 fs-18">Pearl Venture, First Floor, 190/218, Outer Ring Road, Agara, 1st Sector, HSR Layout, Bangalore - 560102, KA</address>
                </div> --}}
                <div class="contact-info-2 pt-4">
                   <h2 class="ttl-18 mb-3">WhatsApp:</h2>
                   <a href="tel:+91 9342874392" class="ttl-28 text-decoration-none text-primary mb-4 d-inline-block">+91 9342874392</a>
                   <h2 class="ttl-18 pt-3">Email ID:</h2>
                   <a href="mailto:support@magneticphotoframes.com" class="ttl-28 text-decoration-none text-primary d-inline-block mb-0">support@magneticphotoframes.com</a>
                </div>
             </div>
          </div>
          <div class="col-md-5">
             <div class="ms-auto ContactForm_contactFormWrp__4NjEW">
                <form class="contact-form" id="contactForm" method="post" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="mb-4"><input placeholder="Full Name" id="NameInput" class="form-control" type="text" name="name"></div>
                    <div class="mb-4"><input placeholder="Phone Number" maxlength="10" id="phoneInput" class="form-control" type="tel" name="phone"></div>
                    <div class="mb-4"><input placeholder="Email" id="emailInput" class="form-control" type="email" name="email"></div>
                    <div class="mb-4"><textarea placeholder="Message" maxlength="255" name="message" id="messageInput" class="form-control"></textarea></div>
                    <div class="d-grid d-md-flex">
                        <button type="submit" class="btn custom-btn filled contact-btn">Send Message</button>
                    </div>
                </form>
                <div id="thankYouMessage" style="display:none;" class="alert alert-success mt-3">
                    Thank you for contacting us!
                </div>
             </div>
          </div>
       </div>
    </div>
</section>

{{-- <section class="contact-map">
    <div class="container">
       <div class="contact-map-child"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="d-block ContactFormMap_gmapIframe__mgKUo" src="https://maps.google.com/maps?width=802&amp;height=400&amp;hl=en&amp;q=Frameley - Pearl Venture&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
    </div>
</section> --}}

@endsection

@push('scripts')

@endpush
