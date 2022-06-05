<div class="info-footer">
    <div class="container">
        <div class="col-12">
            <div class="d-flex justify-content-between px-3 footer">
                <div class="foot-start d-flex flex-column">
                    <a href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}" target="_blank"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
                    <p class="my-3">@lang('footer.main_des')</p>
                </div>
                <div class="d-flex flex-column footer-item">
                    <label class="mb-3">GotoConsult</label>
                    <ul>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/member/terms-customer') : url('/no/medlem/vilkar-kunde') }}">@lang('footer.terms_customer')</a></li>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/member/privacy') : url('/no/medlem/personvern') }}">@lang('footer.privacy_policy')</a></li>
                    </ul>
                </div>
                <div class="d-flex flex-column footer-item">
                    <label class="mb-3">@lang('footer.consultants')</label>
                    <ul>
                        @foreach ($categories as $key => $category)
                            <?php
                                $url = $lang == 'en' ? url('/find-consultant-search?name=null&category='.$category->category_name.'&price=null&status=null&country=null') : url('/no/finn-konsulent-sok?name=null&category='.$category->category_name.'&price=null&status=null&country=null');
                                $category_name = $lang == 'en' ? $category->category_name : $category->category_name_no;
                            ?>
                            <li class="py-2">
                                <a href="{{ $url }} ">{{ $category_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex flex-column footer-item">
                    <label class="mb-3">@lang('footer.become_consultant')</label>
                    <ul>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/member/terms-consultant') : url('/no/medlem/vilkar-konsulent') }}">@lang('footer.terms_consultant')</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    <?php $year = date("Y"); ?>
                    ©{{$year}}&nbsp;@lang('footer.description') &nbsp;<a href="https://fantasylab.io" target="_blank">FantasyLab</a>
                </div>
                <div class="d-flex">
                    <img src="{{ asset('images/facebook.svg')}}">
                    <img src="{{ asset('images/instagram.svg')}}">
                </div>
            </div>
        </div>
    </div>
</div>
