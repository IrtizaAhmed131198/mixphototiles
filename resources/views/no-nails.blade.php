@extends('components.layouts.app')

@section('title', 'Photo Frames Without Nails | No Drill, No Wall Damage | Magnetick')
@section('description', 'Looking for photo frames without nails? Magnetick frames use magnets + iron sheet to hang on walls with no drilling, no glue, and no wall damage. Rental-friendly & reusable.')
@section('keywords', 'photo frames without nails, no drill photo frames, wall frames without drilling, rental friendly wall decor, magnetic photo frames for wall')
@section('canonical', url('/photo-frames-without-nails'))

{{-- Optional OG image (pick a real banner image you already have) --}}
@section('og_image', asset('assets/images/og-no-nails.jpg'))

@push('css')
<style>
    .no-nails-hero{
        padding: 72px 0 40px;
        background: radial-gradient(1200px 600px at 50% -10%, rgba(255, 1, 104, 0.12), transparent 60%),
                    #fff;
    }
    .no-nails-hero h1{
        font-weight: 800;
        letter-spacing: -0.3px;
        margin-bottom: 12px;
    }
    .no-nails-hero .lead{
        max-width: 780px;
        margin: 0 auto 18px;
        color: rgba(0,0,0,0.75);
        line-height: 1.6;
    }
    .no-nails-badges{
        display:flex;
        flex-wrap:wrap;
        justify-content:center;
        gap:25px;
        margin-top: 32px;
    }
    .no-nails-badge{
        background: rgba(255, 1, 104, 0.10);
        border: 1px solid rgba(255, 1, 104, 0.18);
        color: #222;
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.95rem;
    }
    .no-nails-section{
        padding: 70px 0;
        background:#fafafa;
        border-top: 1px solid rgba(0,0,0,0.04);
        border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    #two-buts{
        padding: 16px 0;
    }
    p.no-nails-para{
        padding: 0 140px 0 0;
    }
    .no-nails-card{
        background:#fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        height:100%;
    }
    .no-nails-card h3{
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .no-nails-card p{
        margin:0;
        color: rgba(0,0,0,0.75);
        line-height: 1.6;
    }
    .no-nails-cta{
        padding: 46px 0;
        background:#fff;
    }
    .no-nails-faq{
        padding: 50px 0;
        background:#fff;
    }
    .brand-link{
        color:#9d0b78;
        font-weight:700;
        text-decoration:none;
    }
    .brand-link:hover{ text-decoration: underline; }
</style>
@endpush

@section('content')
<main style="margin-top:56px;">

    {{-- HERO --}}
    <section class="no-nails-hero text-center">
        <div class="container">
            <h1>Photo Frames Without Nails (No Drill, No Wall Damage)</h1>
            <p class="lead">
                Want to decorate your wall without drilling? <a href="{{ url('/') }}" class="brand-link">MagnetickPhotoFrames.com</a>
                lets you hang photo frames using a thin iron sheet + strong magnets. So you can move, rearrange, or remove frames anytime without marks.
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('design') }}" class="btn design-btn filled">Design Your Frame</a>
                <a href="{{ route('collections') }}" class="btn design-btn filled">Explore Collections</a>
            </div>

            <div class="no-nails-badges">
                <span class="no-nails-badge">No Nails</span>
                <span class="no-nails-badge">No Drilling</span>
                <span class="no-nails-badge">Rental‑Friendly</span>
                <span class="no-nails-badge">Reusable</span>
                <span class="no-nails-badge">Clean Removal</span>
            </div>
        </div>
    </section>

    {{-- BENEFITS --}}
    <section class="no-nails-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="no-nails-card">
                        <h3>Hang frames without drilling</h3>
                        <p>Perfect for rented homes, painted walls, and apartments where you don’t want holes or cracks.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="no-nails-card">
                        <h3>Move and re‑arrange anytime</h3>
                        <p>Change layouts whenever you want. Staircase walls, bedroom grids, or living room clusters.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="no-nails-card">
                        <h3>Clean, damage‑free removal</h3>
                        <p>No glue residue, no peeling paint, and no sticker mess. Just remove and keep your wall clean.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="no-nails-cta">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h2 class="heading-3">How it works</h2>
                    <p class="no-nails-para">
                        Magnetick uses a thin iron sheet that sits flush on your wall. The frame snaps on magnetically and stays stable.
                        You can reposition it multiple times without damaging the wall surface.
                    </p>
                    <div class="d-flex gap-3 flex-wrap" id="two-buts">
                        <a href="{{ route('design') }}" class="btn design-btn filled">Upload Photos & Design</a>
                        <a href="{{ route('shipping') }}" class="btn design-btn filled">Shipping Info</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="no-nails-card">
                        <h3>Best for</h3>
                        <p>Bedrooms, Staircase walls, Living rooms, Rental homes, Hotels, Offices, Apartments, Hostels, Event halls</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="no-nails-faq">
        <div class="container">
            <h2 class="heading-3 text-center mb-4">FAQs: Photo Frames Without Nails</h2>

            <div class="accordion accordion-flush" id="noNailsFaq">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a1">
                            Do these frames damage walls?
                        </button>
                    </h2>
                    <div id="a1" class="accordion-collapse collapse" data-bs-parent="#noNailsFaq">
                        <div class="accordion-body">
                            No. They are designed for clean removal without drilling or nail holes. Proper application keeps painted walls safe.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="q2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                            Can I reposition them multiple times?
                        </button>
                    </h2>
                    <div id="a2" class="accordion-collapse collapse" data-bs-parent="#noNailsFaq">
                        <div class="accordion-body">
                            Yes. You can move and re‑arrange your layouts whenever you like.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="q3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3">
                            Are these suitable for rented homes?
                        </button>
                    </h2>
                    <div id="a3" class="accordion-collapse collapse" data-bs-parent="#noNailsFaq">
                        <div class="accordion-body">
                            Yes. The system is rental‑friendly because it avoids drilling, stickering and reduces wall damage risk.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Optional: FAQ Schema for rich results --}}
    
    @verbatim
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"FAQPage",
      "mainEntity":[
        {
          "@type":"Question",
          "name":"Do these frames damage walls?",
          "acceptedAnswer":{
            "@type":"Answer",
            "text":"No. They are designed for clean removal without drilling or nail holes."
          }
        }
      ]
    }
    </script>
    @endverbatim


</main>
@endsection