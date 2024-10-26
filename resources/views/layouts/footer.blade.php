<footer class="bg-black text-light py-5">
    <div class="container">
        <div class="row text-end">
            <!-- Contact Information -->
            <div class="col-md-4 mb-4">
                <h5 class="text-white">Contact Us</h5>
                @foreach($contactinfos as $contactinfo)
                    <ul class="list-unstyled">
                        <li>Phone: <a href="tel:{{ $contactinfo->phn_number }}" class="text-white">{{ $contactinfo->phn_number }}</a></li>
                        <li>Address: <span class="text-white">{{ $contactinfo->adaddress }}</span></li>
                        <li>Location: <span class="text-white">{{ $contactinfo->location }}</span></li>
                    </ul>
                @endforeach
            </div>

            <!-- Social Media Links -->
            <div class="col-md-4 mb-4">
                <h5 class="text-white">Follow Us</h5>
                <div class="d-flex justify-content-end">
                    @foreach($contactinfos as $contactinfo)
                        @if($contactinfo->facebook)
                            <a href="{{ $contactinfo->facebook }}" class="text-white me-3 icon-blur" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($contactinfo->insta)
                            <a href="{{ $contactinfo->insta }}" class="text-white me-3 icon-blur" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($contactinfo->twitter)
                            <a href="{{ $contactinfo->twitter }}" class="text-white me-3 icon-blur" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row mt-4 text-center">
            <div class="col">
                <p class="text-white">&copy; 2024 Your Company Name. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- FontAwesome for social icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<!-- Additional CSS to beautify footer -->
<style>
    footer {
        color:white;
        background-color: black;
    }
    footer h5 {
        font-weight: bold;
        margin-bottom: 20px;
    }
    footer ul li {
        margin-bottom: 10px;
    }
    footer a.text-white {
        text-decoration: none;
        transition: filter 0.3s;
    }
    footer a.text-white:hover {
        color: #f1c40f; /* Change to a gold color on hover */
    }
    .fab {
        font-size: 1.5rem;
    }
    .icon-blur {
        filter: blur(1px); /* Apply blur effect */
    }
</style>
