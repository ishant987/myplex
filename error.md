 sed -n '35,110p' resources/views/web/composition_report/scheme_portfolio.blade.php
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="fund_master" id="fund_master" class="select2">
                                            <option>Select Any Funds</option>
                                            @if (isset($fund_master))
                                                @foreach ($fund_master as $val)
                                                    <option value="{{ data_get($val, 'fund_code', '') }}"
                                                        {{ request()->get('fund_master') == data_get($val, 'fund_code') ? 'selected' : '' }}>
                                                        {{ data_get($val, 'fund_name', '') }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="month" id="month" required>
                                            <option value="">select month</option>
                                            @foreach ($months as $m)
                                                <option value="{{ $m }}"
                                                    {{ isset($month) && $month == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="year" id="year" required>
                                            <option value="">select year</option>
                                            @foreach ($years as $y)
                                                <option
                                                    value="{{ $y }}"{{ isset($year) && $year == $y ? 'selected' : '' }}>
                                                    {{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" name="search" value="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (isset($scrips) && count($scrips) > 0)
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>AUM of fund(Rs.In Crores):</p>
                                    <span>{{ isset($total_corpus_entry) ? number_format($total_corpus_entry,2): '' }}</span>
                                </li>

                                <li>
                                    <p>name of Fund :</p>
                                    <span>{{ data_get($fund_details, 'fund_name', '') }}</span>
                                </li>
                                <li>
                                    <p>Scheme Portfolio :</p>
                                    <span>For the month of
                                        {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : '' }},{{ isset($year) ? $year : '' }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">

                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>[myplexus.com_o0fa2fikmf@host httpdocs]$ sed -n '190,215p' storage/framework/views/5fdb18b99806d7da60ad079d2e10cf4d61694d28.php
sed: can't read storage/framework/views/5fdb18b99806d7da60ad079d2e10cf4d61694d28.php: No such file or directory

                       
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                
[myplexus.com_o0fa2fikmf@host httpdocs]$ sed -n '190,215p' storage/framework/views/5fdb18b99806d7da60ad079d2e10cf4d61694d28.php
sed: can't read storage/framework/views/5fdb18b99806d7da60ad079d2e10cf4d61694d28.php: No such file or directory
[myplexus.com_o0fa2fikmf@host httpdocs]$ tail -n 40 storage/logs/laravel.log
#24 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Session/Middleware/AuthenticateSession.php(58): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#25 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Session\\Middleware\\AuthenticateSession->handle()
#26 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php(44): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#27 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Auth\\Middleware\\Authenticate->handle()
#28 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#29 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle()
#30 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#31 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest()
#32 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Session\\Middleware\\StartSession->handle()
#33 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#34 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle()
#35 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#36 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle()
#37 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#38 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Routing/Router.php(719): Illuminate\\Pipeline\\Pipeline->then()
#39 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Routing/Router.php(698): Illuminate\\Routing\\Router->runRouteWithinStack()
#40 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Routing/Router.php(662): Illuminate\\Routing\\Router->runRoute()
#41 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Routing/Router.php(651): Illuminate\\Routing\\Router->dispatchToRoute()
#42 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(167): Illuminate\\Routing\\Router->dispatch()
#43 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(128): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}()
#44 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#45 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle()
#46 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle()
#47 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#48 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle()
#49 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle()
#50 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#51 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle()
#52 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(86): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#53 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle()
#54 /var/www/vhosts/myplexus.com/httpdocs/vendor/fruitcake/laravel-cors/src/HandleCors.php(52): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#55 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Fruitcake\\Cors\\HandleCors->handle()
#56 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#57 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\\Http\\Middleware\\TrustProxies->handle()
#58 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#59 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(142): Illuminate\\Pipeline\\Pipeline->then()
#60 /var/www/vhosts/myplexus.com/httpdocs/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(111): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter()
#61 /var/www/vhosts/myplexus.com/httpdocs/public/index.php(49): Illuminate\\Foundation\\Http\\Kernel->handle()
#62 {main}
"} 
[myplexus.com_o0fa2fikmf@host httpdocs]$ 