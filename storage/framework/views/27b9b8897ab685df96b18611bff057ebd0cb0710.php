<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery-validate'); ?> <?php $__env->stopSection(); ?>
<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .custom-banner {
        background-image: url('<?php echo e($dataArr['image_path']); ?>');
    }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4><?php echo nl2br($dataArr['title']); ?></h4>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="compare_scheme mf_classification">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="plan_faq mt-0">
                        <div class="pentatech_filter_title">
                            <h4>Debt Funds</h4>
                        </div>
                        <div class="single_fund_calc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund1.png')); ?>" />
                                        <h4>Liquid & Money Market Funds</h4>
                                        <p>A money market funds invest predominantly in highly liquid money market and debt securities such as treasury bills, commercial paper, certificate of deposit etc. Liquid funds have a maturity period of 91 days. Money market funds have a maturity period of 1 year.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund2.png')); ?>" />
                                        <h4>Income Funds</h4>
                                        <p>Income Funds mainly focus on generating regular income by investing in high dividend generating stocks, corporate bonds, government securities etc. SEBI classifies income funds as those debt funds whose Macaulay duration is 4 years and more. </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund3.png')); ?>" />
                                        <h4>Fixed Maturity Plans</h4>
                                        <p>Fixed Maturity Plans are closed-ended debt fund which comes with fixed lock-in period and limited investment window. Investor can only invest in such securities during NFO (new fund offering). The tenure of an FMP may range from 30days to 60 months.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund4.png')); ?>" />
                                        <h4>Capital Protection Oriented Fund</h4>
                                        <p>Capital Protection-Oriented Funds aim to protect investor’s capital. The minimum debt exposure is fixed at 80% which manages to generate 100% of the principal invested and the remaining 20% comprising equity manages to generate an upside to the portfolio.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund5.png')); ?>" />
                                        <h4>Interval Funds</h4>
                                        <p>Interval Fund is a mutual fund wherein the fund house allows to purchaseor sell the units only during specified transaction periods (STPs) at predetermined intervals.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund6.png')); ?>" />
                                        <h4>Multiple Yield Fund</h4>
                                        <p>Multiple Yield Funds are Hybrid Debt-Oriented Funds that invests predominantly in debt instruments and to some extent in dividend-yielding equities.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund12.png')); ?>" />
                                        <h4>Short-Term Fund</h4>
                                        <p>Short-Term Debt Funds primarily invest in debt instruments with shorter maturity or duration (1 to 3 years).
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund7.png')); ?>" />
                                        <h4>Floating Rate Funds</h4>
                                        <p>A Floating Rate Fund invests in bonds and debt instruments whose interest payments fluctuate with an underlying interest rate level. </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund8.png')); ?>" />
                                        <h4>Gilt Funds</h4>
                                        <p>Gilt Funds only invest in fixed-interest generating securities issued by the central and state government for various tenures.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund9.png')); ?>" />
                                        <h4>Dynamic Bond Fund</h4>
                                        <p>Dynamic Bond Funds are a class of debt mutual fund that alter allocations between short-term and long-term bonds based on interest rate movement.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund10.png')); ?>" />
                                        <h4>Monthly Income Plan</h4>
                                        <p>Monthly Income Plan invests in a combination of debt and equity securities. It invests pre-dominantly in debt securities and 15-25% in equities.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund11.png')); ?>" />
                                        <h4>Hybrid Debt</h4>
                                        <p>Monthly Income Plan invests in a combination of debt and equity securities. It invests pre-dominantly in debt securities and 15-25% in equities.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- HYBRID FUNDS : 1) HYBRID FUNDS-->

<section class="compare_scheme mf_classification">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="plan_faq mt-0">
                        <div class="pentatech_filter_title">
                            <h4>HYBRID FUNDS</h4>
                        </div>
                        <div class="single_fund_calc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund1.png')); ?>" />
                                        <h4>Aggressive Hybrid Fund</h4>
                                        <p>Aggressive Hybrid Funds invest between 65-80% of their total assets in equity
                                            and equity-related instruments and the balance 20-35% in debt securities and
                                            money market instruments.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund2.png')); ?>" />
                                        <h4>Balanced Hybrid Fund</h4>
                                        <p>Balanced Hybrid Funds invest between 40-60% of their total assets in equity
                                            and equity-related instruments and the balance 40-60% in debt securities.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund3.png')); ?>" />
                                        <h4>Conservative Hybrid Fund</h4>
                                        <p>Conservative Hybrid Funds invest between 10-25% of their total assets in
                                            equity and equity-related instruments and the balance 75-90% in debt
                                            securities
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund4.png')); ?>" />
                                        <h4>Dynamic Asset Allocation</h4>
                                        <p>Dynamic Asset Allocation means adjusting the mix of assets in a portfolio
                                            based on market trends. </br> It is less concerned with maintaining a
                                            specific mix of assets than maximizing return potential.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund5.png')); ?>" />
                                        <h4>Multi Asset Allocation</h4>
                                        <p>Multi Asset Allocation Funds are hybrid fund that must invest a minimum of
                                            10% in at least 3 asset classes. These funds typically have a combination of
                                            Equity, Debt, Gold, Real Estate, etc.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund6.png')); ?>" />
                                        <h4>Arbitrage Fund</h4>
                                        <p>Arbitrage Funds takes advantage of the price differences between current and
                                            future securities to generate maximum returns. The fund manager
                                            simultaneously buys shares in the cash market and sells it in future market.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund12.png')); ?>" />
                                        <h4>Equity Saving Fund</h4>
                                        <p>Equity Mutual Fund predominantly invest in equities, arbitrage and debt
                                            securities to generate return. It invests minimum of 65% of total asset in
                                            equities, including arbitrage and a minimum of 10% in debt.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HYBRID FUNDS : 2) EXCHANGE TRADED FUNDS-->

<section class="compare_scheme mf_classification">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="plan_faq mt-0">
                        <div class="pentatech_filter_title">
                            <h4>Exchange Traded Funds</h4>
                        </div>
                        <div class="single_fund_calc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund1.png')); ?>" />
                                        <h4>Open Ended ETF</h4>
                                        <p>ETF trades like a common stock on a stock exchange. ETFs are similar in many
                                            ways to mutual funds, expect that ETFs are bought and sold throughout the
                                            day on stock exchanges. ETFs typically have higher daily liquidity and lower
                                            fees than mutual fund schemes.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund2.png')); ?>" />
                                        <h4>Gold ETF</h4>
                                        <p>A Gold ETF is an Exchange-Traded fund (ETF) that aims to track the domestic
                                            physical gold price. Gold ETFs are units representing physical gold which
                                            may be in paper or dematerialised form. </br> One Gold ETF unit = 1 gm of
                                            gold.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund3.png')); ?>" />
                                        <h4>Open Ended Other ETF</h4>
                                        <p>The most common types of ETF are: - <br>
                                            I. Long ETFs: - If the index rises then share price also rises in long ETFs.
                                            <br>
                                            II. Inverse ETFs: - Share prices move in the opposite direction. If index
                                            loses
                                            money, you win. <br>
                                            III. Industry ETFs: - Portfolio of stocks representing an industry like oil,
                                            mining, health care, etc. <br>
                                            IV. Bond ETFs: - Instead of stocks they own bond. <br>
                                            V. Currency ETFs: - Seek to capture returns of foreign currencies.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- HYBRID FUNDS : 3) FUND OF FUNDS-->

<section class="compare_scheme mf_classification">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="plan_faq mt-0">
                        <div class="pentatech_filter_title">
                            <h4>Fund of Funds (FoF)</h4>
                        </div>
                        <div class="single_fund_calc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund1.png')); ?>" />
                                        <h4>FOF Domestic</h4>
                                        <p>FOF- Domestic Funds are those schemes that invest 95% of the total assets in
                                            domestic funds.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund2.png')); ?>" />
                                        <h4>FOF Overseas</h4>
                                        <p>FOF-Overseas Funds are those schemes that invests in companies outside the
                                            investor’s country of residence.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- HYBRID FUNDS : 4) SOLUTION ORIENTED FUND-->

<section class="compare_scheme mf_classification">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="plan_faq mt-0">
                        <div class="pentatech_filter_title">
                            <h4>Solution Oriented Fund</h4>
                        </div>
                        <div class="single_fund_calc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund1.png')); ?>" />
                                        <h4>Solution-Oriented Retirement Fund</h4>
                                        <p>Retirement Fund aim to provide financial assistance to the retirees by
                                            gathering the capital during the earning age of the investor. <br>
                                            These funds follow an aggressive style of investment by selecting high-risk
                                            stocks in the portfolio when the investor is in the young and earning stage.
                                            As the investor approaches the retirement age, the corpus is generally
                                            shifted to a moderate or conservative plan of the same scheme. After the
                                            retirement the portfolio can conserve the gathered amount and add regular
                                            income
                                            through debt securities.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<!-- Equity Funds Starts -->


<section class="compare_scheme mf_classification">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="plan_faq mt-0">
                        <div class="pentatech_filter_title">
                            <h4>EQUITY FUNDS</h4>
                        </div>
                        <div class="single_fund_calc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund1.png')); ?>" />
                                        <h4>1.Large Cap
                                            Equity Fund
                                        </h4>
                                        <p> Large Cap Equity Funds invest a bigger proportion of their total assets in
                                            companies with a large market capitalization. At least 80% of the portfolio
                                            should be invested in top 100 companies by market capitalisation.

                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund2.png')); ?>" />
                                        <h4>2.Mid Cap
                                            Equity Fund</h4>
                                        <p>Mid Cap Equity Funds invest in stocks of mid-size companies which are
                                            considered as developing companies.
                                            At least 65% of the portfolio should be invested in companies ranked
                                            between 101-250 by market capitalisation. </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund3.png')); ?>" />
                                        <h4>3.Small Cap
                                            Equity Fund </h4>
                                        <p>Small Cap Equity Funds invest in stocks of small-sized companies.
                                            At least 80% of the portfolio should be invested in companies ranked below
                                            the 250th rank by market capitalisation.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund4.png')); ?>" />
                                        <h4>4.Multi Cap
                                            Equity Fund</h4>
                                        <p>Multi Cap Equity fund are diversified equity funds that invest in stocks of
                                            companies with different market capitalizations. Proportion of large cap,
                                            mid cap and small cap will depend upon the risk tolerance of the investor.

                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="single_classification h-100">
                                        <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund5.png')); ?>" />
                                        <h4>5.Sectoral/The
                                            matic Equity
                                            Fund</h4>
                                        <p>Sectoral Funds invest in only one sector. These sectors can be
                                            infrastructure, energy, pharma, banking etc.At least 80% of the portfolio
                                            should be invested in a particular sector.
                                            <br>
                                            AndThematic Funds invest across multiple sectors that are related to a
                                            certain theme such as rural India, export-oriented, international exposure
                                            etc. At least 80% of the portfolio should be invested in stock of a
                                            determined theme

                                        </p>
                                    </div>
								</div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund6.png')); ?>" />
                                            <h4>6. ELSS Fund
                                                (Equity Linked
                                                Saving
                                                Scheme)</h4>
                                            <p>ELSS is the only scheme qualifies for tax deduction under section 80(c)
                                                of
                                                the IT Act. Investment up to 1.5 lakh in ELSS is eligible for deduction
                                                from
                                                taxable income. It comes with a statutory lock in period of 3 years for
                                                each
                                                SIP.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund12.png')); ?>" />
                                            <h4>7. Contra
                                                Equity</h4>
                                            <p>Contra Equity Fund follows a contrarian investment strategy which means
                                                against the market trend. The strategy involves buying of assets that
                                                are
                                                either depressed or under-performing at that point of time.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund7.png')); ?>" />
                                            <h4>8. Equity
                                                Dividend Yield
                                                Fund</h4>
                                            <p>Dividend Yield Funds invest in companies which are known to declare high
                                                dividends. It invests around 70-80% of its portfolio in stocks that have
                                                a
                                                dividend yield higher than that of the market. Good for investors who
                                                want
                                                to invest in equity but with low volatility.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund8.png')); ?>" />
                                            <h4>9.Equity
                                                Focused Fund</h4>
                                            <p>Focused Funds invest in a limited number of stocks which should not be
                                                more than 30. Not more than 10% of the portfolio is allocated to a
                                                single
                                                stock. It holds stocks in less than three sectors only.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund9.png')); ?>" />
                                            <h4>10.Growth
                                                Equity Fund</h4>
                                            <p>Growth Fund invests in growth stocks to achieve maximum capital
                                                appreciation with little or no dividend pay-outs. Growth stock means
                                                stocks
                                                of a company with a track record of great revenue growth or younger
                                                companies with potential.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund10.png')); ?>" />
                                            <h4>11. Equity
                                                Index Fund</h4>
                                            <p>Index Fund invests in stock that imitate a stock market index like BSE
                                                Sensex, NSE Nifty etc.
                                                It ensures that it invests in all the securities that the index tracks.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund11.png')); ?>" />
                                            <h4>12. Equity
                                                Large & Mid
                                                Cap Fund

                                            </h4>
                                            <p>Large and Mid-Cap Fund invests in the stock of companies with large and
                                                medium-sized capitalisations.
                                                <br>
                                                These funds are bound to invest a minimum of 35% each of their total
                                                asset
                                                in equity and equity-related instruments of large and mid-cap companies.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="single_classification h-100">
                                            <img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund10.png')); ?>" />
                                            <h4>13. Equity
                                                Value Fund</h4>
                                            <p>Equity Value Fund invests in stocks that are currently trading on
                                                discount
                                                due to some reason but have long term potential. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
</section>

<!-- Equity Funds Ends -->



<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/mutual-fund-classifications.blade.php ENDPATH**/ ?>