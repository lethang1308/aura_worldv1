@if($banners->count() > 0)
<div class="banner-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicators/dots -->
                    <div class="carousel-indicators">
                        @foreach($banners as $index => $banner)
                            <button type="button" data-bs-target="#bannerCarousel" 
                                    data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}" 
                                    aria-label="Slide {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>

                    <!-- The slideshow/carousel -->
                    <div class="carousel-inner">
                        @foreach($banners as $index => $banner)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" target="_blank">
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             alt="{{ $banner->title }}" 
                                             class="d-block w-100" 
                                             style="height: 400px; object-fit: cover;">
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         alt="{{ $banner->title }}" 
                                         class="d-block w-100" 
                                         style="height: 400px; object-fit: cover;">
                                @endif
                                
                                @if($banner->title || $banner->description)
                                    <div class="carousel-caption d-none d-md-block">
                                        @if($banner->title)
                                            <h5>{{ $banner->title }}</h5>
                                        @endif
                                        @if($banner->description)
                                            <p>{{ $banner->description }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Left and right controls/icons -->
                    @if($banners->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.secondary-banner-full {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    margin-bottom: 20px;
}

.secondary-banner-full:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.banner-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.banner-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 100%;
}

.banner-image {
    width: 100%;
    height: 100%;
    min-height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.secondary-banner-full:hover .banner-image {
    transform: scale(1.02);
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.6) 100%);
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    opacity: 1;
    transition: opacity 0.3s ease;
}

.banner-content {
    text-align: left;
    color: white;
    padding: 40px;
    max-width: 50%;
}

.banner-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    text-transform: uppercase;
}

.banner-description {
    font-size: 1.3rem;
    margin-bottom: 25px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
    font-weight: 500;
}

.banner-cta {
    display: inline-block;
    background: rgba(255, 255, 255, 0.95);
    color: #333;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.banner-cta:hover {
    background: white;
    transform: scale(1.05);
    color: #333;
}

@media (max-width: 768px) {
    .banner-image {
        min-height: 300px;
    }
    
    .banner-content {
        padding: 20px;
        max-width: 100%;
        text-align: center;
    }
    
    .banner-title {
        font-size: 1.8rem;
    }
    
    .banner-description {
        font-size: 1.1rem;
    }
}
</style>
@endif 