@if($secondaryBanners->count() > 0)
    <div class="container">
        <div class="row">
            @foreach($secondaryBanners as $banner)
                <div class="col-12">
                    <div class="secondary-banner-full">
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank" class="banner-link">
                                <div class="banner-image-wrapper">
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         alt="{{ $banner->title }}" 
                                         class="banner-image">
                                    <div class="banner-overlay">
                                        <div class="banner-content">
                                            @if($banner->title)
                                                <h3 class="banner-title">{{ $banner->title }}</h3>
                                            @endif
                                            @if($banner->description)
                                                <p class="banner-description">{{ $banner->description }}</p>
                                            @endif
                                            <span class="banner-cta">Khám phá ngay</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="banner-image-wrapper">
                                <img src="{{ asset('storage/' . $banner->image) }}" 
                                     alt="{{ $banner->title }}" 
                                     class="banner-image">
                                <div class="banner-overlay">
                                    <div class="banner-content">
                                        @if($banner->title)
                                            <h3 class="banner-title">{{ $banner->title }}</h3>
                                        @endif
                                        @if($banner->description)
                                            <p class="banner-description">{{ $banner->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

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