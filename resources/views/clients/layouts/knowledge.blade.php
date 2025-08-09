@extends('clients.layouts.default')

@section('content')
    <div class="banner-section">
        <div class="container"> 

            {{-- <head>
                <meta charset="UTF-8">
                <title>Kiến Thức Nước Hoa</title>
               
            </head>

            <body> --}}
                <h1>Kiến Thức Nước Hoa</h1>

                <div class="section">
                    <h2>1. Các loại nồng độ nước hoa</h2>
                    <ul>
                        <li><b>Parfum (Extrait):</b> Nồng độ tinh dầu cao nhất, lưu hương 8–12 tiếng.</li>
                        <li><b>Eau de Parfum (EDP):</b> Lưu hương khoảng 6–8 tiếng.</li>
                        <li><b>Eau de Toilette (EDT):</b> Nhẹ nhàng, lưu hương 4–6 tiếng.</li>
                        <li><b>Eau de Cologne (EDC):</b> Nồng độ thấp, hương thơm ngắn.</li>
                    </ul>
                </div>

                <div class="section">
                    <h2>2. Cách lưu giữ nước hoa</h2>
                    <p>Tránh ánh nắng trực tiếp và nhiệt độ cao. Bảo quản ở nơi khô ráo, thoáng mát để giữ hương lâu hơn.
                    </p>
                </div>

                <div class="section">
                    <h2>3. Mẹo xịt nước hoa</h2>
                    <p>Xịt vào những vùng có mạch đập như cổ tay, sau tai, cổ để hương lan tỏa tốt hơn.</p>
                </div>
            {{-- </body>

            </html> --}}

        </div>
    </div> 
     <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                        line-height: 1.6;
                        background-color: #f9f9f9;
                    }

                    h1 {
                        color: #b5651d;
                    }

                    .section {
                        background: white;
                        padding: 15px;
                        margin-bottom: 15px;
                        border-radius: 8px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
               
     
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
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%);
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
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            text-transform: uppercase;
        }

        .banner-description {
            font-size: 1.3rem;
            margin-bottom: 25px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
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
    @endsection
