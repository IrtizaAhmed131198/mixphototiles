@extends('components.layouts.app')

@section('title', 'Customer Reviews')
@section('description', 'Read customer experiences and share your feedback about Magnetick photo frames and tiles.')
@section('canonical', route('reviews.index'))

@push('css')
    <link rel="stylesheet" href="{{ asset('css/reviews-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endpush

@section('content')
<main class="reviews-preview reviews-page">
    <section class="hero">
        <div class="wrap hero-inner">
            <p class="eyebrow">LITTLE MOMENTS. LASTING MEMORIES.</p>
            <h1>Your walls.<br>Your stories.</h1>
            <p class="hero-description">A home feels more like you with memories on the wall.<br>Read our community’s stories, or share a little of your own.</p>
            <a href="#write-review" class="button">Share your experience <span aria-hidden="true">↗</span></a>
            <div class="hero-caption"><span aria-hidden="true">♡</span> Every experience helps us make yours better.</div>
            <div class="hero-gallery" aria-hidden="true">
                <img src="{{ asset('assets/images/1704465682987.jpeg') }}" alt="">
                <img src="{{ asset('assets/images/1704466334764.jpeg') }}" alt="">
                <img src="{{ asset('assets/images/1704698692581.jpeg') }}" alt="">
            </div>
        </div>
    </section>
    <section class="wrap community" aria-labelledby="community-heading">
        <div class="section-heading"><div><p class="eyebrow">THE COMMUNITY WALL</p><h2 id="community-heading">Memories worth sharing.</h2></div><p>Experiences from our customers.<br>A little inspiration for your next favourite wall.</p></div>
        <div class="reviews-layout">
            <div class="review-list">
                <div class="review-toolbar">
                    <p><strong>{{ $reviews->total() }}</strong> {{ $reviews->total() === 1 ? 'review' : 'reviews' }}</p>
                    <form method="GET" action="{{ route('reviews.index') }}">
                        <label for="review-filter">Show <select name="rating" id="review-filter">
                            <option value="">All ratings</option>
                            @for ($stars = 5; $stars >= 1; $stars--)
                                <option value="{{ $stars }}" @selected((string) $rating === (string) $stars)>{{ $stars }} {{ $stars === 1 ? 'star' : 'stars' }}</option>
                            @endfor
                        </select><button class="filter-submit" type="submit">Apply</button></label>
                    </form>
                </div>
                @forelse ($reviews as $review)
                    <article class="review-card">
                        <div class="review-top">
                            <div class="reviewer"><span class="avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($review->name, 0, 1)) }}</span><div><h3>{{ $review->name }}</h3><p>{{ $review->created_at->format('d M Y') }}</p></div></div>
                            <span class="stars" aria-label="{{ $review->rating }} out of 5 stars"><span aria-hidden="true">{{ str_repeat('★', $review->rating) }}<span class="star-muted">{{ str_repeat('★', 5 - $review->rating) }}</span></span></span>
                        </div>
                        @if ($review->title)<h4>{{ $review->title }}</h4>@endif
                        <p class="customer-review-text">{{ $review->review }}</p>
                        <div class="review-bottom"><span>Customer experience</span><span>Published after moderation</span></div>
                    </article>
                @empty
                    <p class="empty-reviews">{{ $rating ? 'No approved reviews with this rating yet. Try another filter.' : 'Your story could be the first. Share your experience with us!' }}</p>
                @endforelse
                @if ($reviews->hasPages())
                    <nav class="review-pagination" aria-label="Review pages">
                        @if ($reviews->onFirstPage())<span>Previous</span>@else<a href="{{ $reviews->previousPageUrl() }}">← Previous</a>@endif
                        <span>Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</span>
                        @if ($reviews->hasMorePages())<a href="{{ $reviews->nextPageUrl() }}">Next →</a>@else<span>Next</span>@endif
                    </nav>
                @endif
                <div class="moderation-note"><span aria-hidden="true">✓</span><p>A thoughtful space for every experience.<br><span>Customer reviews appear here after moderation.</span></p></div>
            </div>
            <aside class="write-card" id="write-review" aria-labelledby="write-heading">
                <span class="form-icon" aria-hidden="true">✎</span><p class="eyebrow">YOUR EXPERIENCE MATTERS</p><h2 id="write-heading">How did we do?</h2><p class="form-description">Tell us what you loved, or what we can do better. We’re listening.</p>
                @if (session('review_submitted'))
                    <div class="submission-status" role="status"><span class="success-icon" aria-hidden="true">✓</span><h3>Thank you for sharing!</h3><p>Your review has been received and is waiting for approval. It will appear here once approved.</p><a class="button button-outline" href="{{ route('reviews.index') }}#write-review">Write another review</a></div>
                @else
                    @if ($errors->any())
                        <div class="review-errors" role="alert"><p>Please check the following:</p><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    <form id="review-form" method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <fieldset class="rating-field"><legend>Your rating <span>*</span></legend><div class="rating-options">
                            @for ($star = 1; $star <= 5; $star++)
                                <label><input type="radio" name="rating" value="{{ $star }}" required @checked((string) old('rating') === (string) $star)><span aria-hidden="true">★</span><span class="sr-only">{{ $star }} {{ $star === 1 ? 'star' : 'stars' }}</span></label>
                            @endfor
                        </div><p id="rating-description" aria-live="polite">Select a star to rate your experience</p></fieldset>
                        <label class="field" for="review-name">Your name <span>*</span><input id="review-name" name="name" placeholder="How should we call you?" maxlength="80" required autocomplete="name" value="{{ old('name') }}"></label>
                        <label class="field" for="review-email">Email address <span>*</span><input id="review-email" name="email" type="email" placeholder="you@example.com" maxlength="255" required autocomplete="email" value="{{ old('email') }}"><small>Your email will stay private.</small></label>
                        <label class="field" for="review-title">A few words to sum it up <span class="optional">Optional</span><input id="review-title" name="title" placeholder="A new favourite corner of our home…" maxlength="120" value="{{ old('title') }}"></label>
                        <label class="field" for="review-message">Your review <span>*</span><textarea id="review-message" name="review" placeholder="How was your experience with your frames or tiles?" rows="4" minlength="10" maxlength="2000" required>{{ old('review') }}</textarea></label>
                        <label class="consent"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>I agree to have my name, rating and review displayed publicly after approval.</span></label>
                        <button type="submit" class="button submit-button">Submit review <span aria-hidden="true">↗</span></button><p class="form-footnote">Reviewed with care before it goes live.</p>
                    </form>
                @endif
            </aside>
        </div>
    </section>
    <section class="closing wrap"><div><p class="eyebrow">MAKE ROOM FOR YOUR MEMORIES</p><h2>Your next favourite wall starts here.</h2></div><div class="closing-actions"><a href="{{ route('collections') }}" class="button button-outline">Explore collections <span aria-hidden="true">↗</span></a><a href="{{ route('design') }}" class="button">Design your frames <span aria-hidden="true">↗</span></a></div></section>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/reviews.js') }}" defer></script>
@endpush
