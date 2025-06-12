@extends('components.layouts.app')

@section('title', 'FAQs')

@push('css')
    <style>
        .faq_pg .faqsidebar ul li {
            padding: 0;
        }

        .faq_pg .faqsidebar ul {
            border: none;
        }

        .faq_pg .faqsidebar ul li a {
            border: none;
            padding: 18px 0;
            font-size: 1.375rem;
            color: #8d8d8d;
        }

        .faq_pg .faq-content h3 {
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: 600;
            color: black;
        }

        .faq_pg .faq-content .accordion-item {
            padding-top: 0;
            padding-left: 0;
            margin: 0;
            border: none !important;
            border-top: 1px solid #e5e5e5 !important;
        }

        .faq_pg .faq-content .accordion-item .accordion-button {
            font-weight: 500;
            padding: 25px 0 !important;
            font-size: 16px;
            color: black !important;
        }

        .faq_pg .faq-content .accordion-item:last-child {
            border-bottom: 1px solid #e5e5e5 !important;
        }

        .faq_pg .faq-content .accordion-item .accordion-body {
            width: 100%;
        }

        .faq_pg .faqsidebar ul li .scroll-link.active {
            color: black;
        }



        .faq_pg .faqsidebar {
            position: sticky;
            z-index: 0;
            top: 0;
        }

        .faqsidebar h1 {
            color: black;
            font-size: 40px;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')

    <section class="faq-section faq_pg">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="faqsidebar">
                        <h1>FAQs</h1>
                        <ul>
                            <li><a href="#website-faq" class="scroll-link active">Website</a></li>
                            <li><a href="#frames-faq" class="scroll-link">Frames</a></li>
                        </ul>
                    </div>

                </div>

                <!-- FAQ Content Area -->
                <div class="col-lg-9">
                    <!-- Website FAQ -->
                    <div id="website-faq" class="faq-content mb-5">
                        <h3>Website FAQs</h3>
                        <div class="accordion accordion-flush" id="websiteAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="websiteQ1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#websiteA1" aria-expanded="false" aria-controls="websiteA1">
                                        How do I use the website?
                                    </button>
                                </h2>
                                <div id="websiteA1" class="accordion-collapse collapse" aria-labelledby="websiteQ1"
                                    data-bs-parent="#websiteAccordion">
                                    <div class="accordion-body">
                                        You can browse, register, and explore various features provided on the site.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="websiteQ2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#websiteA2" aria-expanded="false" aria-controls="websiteA2">
                                        Is registration required?
                                    </button>
                                </h2>
                                <div id="websiteA2" class="accordion-collapse collapse" aria-labelledby="websiteQ2"
                                    data-bs-parent="#websiteAccordion">
                                    <div class="accordion-body">
                                        Yes, registration is required to access personalized features.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Frames FAQ -->
                    <div id="frames-faq" class="faq-content">
                        <h3>Frames FAQs</h3>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        What does Magentick Photo Frames have to offer?
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Magentick Photo Frames offers you to create your own masterpiece with our
                                        customizable photo frames.
                                        Simply upload your images. We’ll print, frame, and deliver them right to your
                                        doorstep.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">
                                        Is it simple to rearrange the tiles?
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        It’s incredibly easy! Each frame comes with strong, re-stickable adhesive stickers
                                        attached to the sides...
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                        aria-controls="flush-collapseThree">
                                        What comes with my order?
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Magentick Photo Frames frames are crafted with a solid foundation, our frames exude
                                        durability and elegance...
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFour" aria-expanded="false"
                                        aria-controls="flush-collapseFour">
                                        Do your photo tiles cost a lot?
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        We offer premium-quality photo tiles at prices designed for everyone...
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFive" aria-expanded="false"
                                        aria-controls="flush-collapseFive">
                                        What size options do the photo tiles offer?
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        You can explore sizes from 8" x 8" to 28" x 36", with the flexibility to
                                        customize...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.scroll-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100, // offset for fixed headers
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.scroll-link').on('click', function(e) {
                e.preventDefault();
                $('.scroll-link').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
@endpush
