<div class="info-footer">
    <div class="container">
        <div class="col-12">
            <div class="d-flex justify-content-between px-3 footer">
                <div class="foot-start d-flex flex-column">
                    <a href="{{ $lang == 'en' ? url('/') : url('/no') }}" target="_blank"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
                    <p class="my-3">@lang('footer.main_des')</p>
                </div>
                <div class="d-flex flex-row justify-content-between footer-link">
                    <div class="d-flex flex-column footer-item">
                        <label class="mb-3">GotoConsult</label>
                        <ul>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/features') : url('/no/funksjoner') }}">@lang('header.features')</a></li>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('footer.about_us')</a></li>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('footer.login')</a></li>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('footer.create_account')</a></li>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/terms-customer') : url('/no/vilkar-kunde') }}">@lang('footer.terms_customer')</a></li>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/privacy') : url('/no/personvern') }}">@lang('footer.privacy_policy')</a></li>
                        </ul>
                    </div>
                    <div class="d-flex flex-column footer-item">
                        <label class="mb-3">@lang('footer.consultants')</label>
                        <ul>
                            @foreach ($categories as $key => $category)
                                <?php
                                    $category_url = $lang == 'en' ? url('/category/'.$category->category_url) : url('/no/kategori/'.$category->category_url);
                                    $category_name = $lang == 'en' ? $category->category_name : $category->category_name_no;
                                ?>
                                <li class="py-2">
                                    <a href="{{ $category_url }} ">{{ $category_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex flex-column footer-item">
                        <label class="mb-3">@lang('footer.become_consultant')</label>
                        <ul>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('footer.become_consultant')</a></li>
                            <li class="py-2"><a href="{{ $lang == 'en' ? url('/terms-consultant') : url('/no/vilkar-konsulent') }}">@lang('footer.terms_consultant')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    <?php $year = date("Y"); ?>
                    ©{{$year}}&nbsp;@lang('footer.description') &nbsp;<a href="https://fantasylab.io" target="_blank">FantasyLab</a>
                </div>
                <div class="d-flex">
                    <a href="https://www.instagram.com/gotoconsult/"><img src="{{ asset('images/facebook.svg')}}"></a>
                    <a href="https://www.instagram.com/gotoconsult/"><img src="{{ asset('images/instagram.svg')}}"></a>
                </div>
            </div>
        </div>
    </div>
</div>
