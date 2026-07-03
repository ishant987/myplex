<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use App\Services\SeoPageService;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    public function run()
    {
        $service = app(SeoPageService::class);
        $assetBase = asset('themes/frontend/assets/images');

        $pages = [
            [
                'page_title' => 'Why Every Indian Needs a Financial Plan',
                'url_slug' => 'financial-needs',
                'page_type' => 'landing',
                'category' => 'Financial Planning',
                'author' => 'Prasun Mukherjee',
                'publish_date' => now()->toDateString(),
                'status' => 'published',
                'short_description' => 'A practical long-form guide to building a financial plan around goals, risk, cash flow, tax, and mutual fund decisions.',
                'full_content' => $this->financialPlanContent($assetBase),
                'tags' => 'financial planning, goals, mutual funds, portfolio review, India',
                'featured_image_url' => $assetBase . '/financial-advisor.jpg',
                'image_alt_text' => 'Financial advisor reviewing a long term investment plan',
                'seo_title' => 'Why Every Indian Needs a Financial Plan',
                'meta_description' => 'Learn how Indian investors can build a practical financial plan around goals, cash flow, risk, tax and mutual funds.',
                'focus_keyword' => 'financial planning India',
                'canonical_url' => 'https://www.myplexus.com/financial-needs',
                'og_title' => 'Why Every Indian Needs a Financial Plan',
                'og_image_url' => $assetBase . '/financial-advisor.jpg',
                'schema_type' => 'Article',
                'is_indexed' => true,
            ],
            [
                'page_title' => 'What is SIP and How Does It Work',
                'url_slug' => 'what-is-sip',
                'page_type' => 'blog',
                'category' => 'SIP',
                'author' => 'Prasun Mukherjee',
                'publish_date' => now()->toDateString(),
                'status' => 'published',
                'short_description' => 'A detailed SIP guide covering how systematic investing works, where it helps, what to watch, and how to review it.',
                'full_content' => $this->sipContent($assetBase),
                'tags' => 'sip, mutual funds, investing, rupee cost averaging, India',
                'featured_image_url' => $assetBase . '/sip-planner-banner.jpg',
                'image_alt_text' => 'Investor planning a SIP for mutual fund investing',
                'seo_title' => 'What is SIP and How Does It Work',
                'meta_description' => 'Understand SIP investing, rupee cost averaging, goal planning, risk and review steps for Indian mutual fund investors.',
                'focus_keyword' => 'what is SIP mutual fund',
                'canonical_url' => 'https://www.myplexus.com/what-is-sip',
                'og_title' => 'What is SIP and How Does It Work',
                'og_image_url' => $assetBase . '/sip-planner-banner.jpg',
                'schema_type' => 'BlogPosting',
                'is_indexed' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            $prepared = $service->prepare($pageData);
            SeoPage::updateOrCreate(
                ['url_slug' => $prepared['url_slug']],
                $prepared
            );
        }

        $this->command->info('SEO pages seeded!');
    }

    private function financialPlanContent($assetBase)
    {
        return <<<HTML
<h1>Why Every Indian Needs a Financial Plan</h1>
<p>Financial planning India is not only about buying a mutual fund, choosing an insurance policy, or reacting to a tax deadline in March. A good plan is a written map of how your income, expenses, savings, assets, liabilities, and life goals work together. It gives every rupee a job before market noise, social media advice, or a sudden product recommendation can pull your decisions in different directions.</p>
<p>For Indian families, the need is even sharper because major goals often overlap. A young professional may be building an emergency fund, supporting parents, planning a home down payment, and starting SIPs at the same time. A mid-career investor may be paying a home loan, preparing for children's education, reviewing term insurance, and thinking about retirement. Without a plan, these goals compete silently. With a plan, they can be ranked, funded, reviewed, and adjusted with far less stress.</p>

<h2>Start with life goals, not products</h2>
<p>The most useful financial plans begin with plain language goals. Instead of starting with "which fund should I buy", start with "what should this money do for me, and when do I need it". A goal can be an emergency reserve, a professional course, a car, a home, education, retirement income, a family vacation, or support for parents. Each goal needs an amount, a time frame, and a priority. Once that is clear, the product choice becomes easier and more rational.</p>
<p>Short-term goals usually need stability and liquidity. Medium-term goals need a balance between growth and protection. Long-term goals can accept more volatility because time allows the investment to recover from market cycles. This is why the same mutual fund cannot be right for every goal. A fund that suits a 15-year retirement goal may be inappropriate for money needed next year. The plan creates the boundary before the investment decision is made.</p>
<figure><img src="{$assetBase}/graph-image.jpg" alt="Investment planning graph" loading="lazy" width="900" height="520"><figcaption>Goals become clearer when the amount, timeline, and risk level are written together.</figcaption></figure>

<h2>Cash flow is the engine of the plan</h2>
<p>Your income may be strong, but your plan works only when cash flow is honest. Many investors underestimate irregular expenses such as insurance premiums, school fees, medical needs, travel, festive spending, home repairs, and professional upskilling. A practical plan separates fixed expenses, flexible expenses, committed savings, and annual expenses. This helps you avoid the common cycle of investing aggressively and then redeeming investments for predictable bills.</p>
<p>One helpful habit is to create a monthly surplus number that is realistic, not heroic. If a household can invest Rs 35,000 every month comfortably, the plan should not assume Rs 60,000 just to make future projections look attractive. Overpromising creates guilt and inconsistency. Underplanning creates missed opportunities. The right number is the amount you can keep investing through normal life, because consistency is often more valuable than intensity.</p>

<h2>Emergency money protects long-term wealth</h2>
<p>An emergency fund is not exciting, but it is one of the strongest parts of a financial plan. It protects your long-term investments from forced withdrawals. Job changes, medical issues, business delays, family emergencies, and sudden repairs are part of real life. When there is no emergency reserve, investors often break SIPs, redeem equity funds at the wrong time, or use high-cost credit. The damage is not only financial; it also breaks confidence.</p>
<p>A simple starting point is three to six months of essential expenses, held in a savings account, sweep account, or liquid fund depending on comfort and access. Families with variable income, dependents, or large loans may need more. The emergency fund should not be treated as a return-maximising investment. Its job is availability. Once that layer is ready, the investor can take long-term risk with greater calm.</p>

<blockquote>A financial plan is not a prediction. It is a decision framework that helps you behave well when markets, income, and life do not move in a straight line.</blockquote>

<h2>Insurance comes before investment ambition</h2>
<p>Many Indian investors focus on returns before protection. That order can be risky. If a family depends on one person's income, term insurance should be reviewed before aggressive investing. Health insurance should be checked for family size, city costs, room rent limits, exclusions, waiting periods, and employer cover dependency. Employer health cover is useful, but it may not be enough if there is a job change or a long medical event.</p>
<p>Insurance is not a substitute for investing, and investing is not a substitute for insurance. Mixing the two often leads to confusion. A financial plan separates risk transfer from wealth creation. Term insurance handles income replacement. Health insurance handles medical shocks. Investments handle goals. When each tool has a clear purpose, the plan becomes cleaner and easier to review.</p>

<h2>Risk tolerance must match both mind and math</h2>
<p>Risk is not only about how much volatility a spreadsheet can tolerate. It is also about how the investor feels when the portfolio falls 10 percent, 20 percent, or more. Some investors say they are long-term investors until the first correction arrives. Others hold too much cash because past losses made them cautious. A plan should respect both sides: the mathematical ability to take risk and the emotional ability to stay invested.</p>
<p>Time horizon, income stability, dependents, loans, age, and past behaviour all matter. A 30-year-old with stable income and no dependents may take more equity exposure for retirement. A 55-year-old nearing a goal may need lower volatility even if they are comfortable with markets. The right asset allocation is not the one that looks most impressive in a backtest. It is the one the investor can follow across cycles.</p>
<figure><img src="{$assetBase}/about-us-image-01.jpg" alt="Planning discussion around investments" loading="lazy" width="900" height="520"><figcaption>Risk planning works best when family needs, time horizons, and liquidity are reviewed together.</figcaption></figure>

<h2>Mutual funds need roles inside the plan</h2>
<p>Mutual funds are powerful because they can support many needs: liquidity, income, asset allocation, diversification, and long-term growth. But the category matters. Overnight or liquid funds may support emergency money. Short duration funds may suit near-term parking. Hybrid funds may help investors who want smoother journeys. Equity funds may support long-term goals. Index funds, flexi cap funds, large cap funds, mid cap funds, and sector funds all carry different expectations and risks.</p>
<p>The plan should define why a fund exists in the portfolio. If a fund is held only because it performed well last year, it may not survive the next review. If it is held because it supports a specific goal or asset allocation, the review becomes more disciplined. MyPlexus research tools can help investors and advisors compare performance, portfolio composition, risk ratios, and fund behaviour so decisions are based on evidence rather than recent noise.</p>

<h2>Tax planning should not happen in isolation</h2>
<p>Tax saving is important, but tax planning should not distort the entire portfolio. Many investors buy ELSS, insurance products, or fixed income products only to complete deductions, without checking whether the product suits their broader plan. A better approach is to include tax rules in the annual review. Look at Section 80C usage, capital gains, debt fund taxation, equity holding periods, tax harvesting possibilities, and the effect of switching funds too frequently.</p>
<p>Tax efficiency is useful when it supports the goal. It becomes harmful when it drives the goal. For example, locking money into a product for tax reasons may be unsuitable if the same money is needed soon. Similarly, avoiding a necessary rebalance only because capital gains tax is due may increase portfolio risk. A plan helps weigh tax cost against investment discipline.</p>

<h2>Review is where the plan becomes real</h2>
<p>A financial plan is not a one-time document. It should change when life changes. Salary increases, bonuses, business income, marriage, children, home loans, parental responsibilities, career breaks, health events, and market cycles can all affect the plan. A yearly review is usually enough for stable families, while major events should trigger an interim review. The review should ask what changed, what stayed the same, and what action is needed.</p>
<p>Review does not mean changing everything. Often the best review ends with small adjustments: increasing SIPs, topping up emergency funds, rebalancing asset allocation, adding insurance, closing unused accounts, updating nominees, or simplifying a crowded portfolio. The goal is not activity. The goal is alignment. A quiet plan that is followed well can beat a complicated plan that is constantly disturbed.</p>

<h2>A simple framework to begin</h2>
<p>If you are starting today, write down your goals, monthly surplus, emergency fund status, insurance cover, current investments, loans, and expected large expenses. Then classify every goal by time frame: under three years, three to seven years, and beyond seven years. Match safer assets to near-term needs and growth assets to long-term needs. Keep the first version simple enough that you can explain it to your family in ten minutes.</p>
<p>From there, improve the plan gradually. Add SIPs for long-term goals. Keep emergency money separate. Review fund overlap. Check whether your portfolio depends too heavily on one style, one category, or one market cap segment. Use research to understand what you own. Most importantly, make the plan visible. A plan hidden in memory is easy to ignore. A plan written clearly can guide decisions when markets become loud.</p>

<p><a href="/what-is-sip">Read next: What is SIP and how does it work?</a></p>
HTML;
    }

    private function sipContent($assetBase)
    {
        return <<<HTML
<h1>What is SIP and How Does It Work</h1>
<p>A Systematic Investment Plan, or SIP, is a simple way to invest a fixed amount into a mutual fund at regular intervals. The amount can be monthly, weekly, or quarterly, though monthly SIPs are the most common. The idea is not that every instalment will be invested at the perfect market level. The idea is that the investor builds discipline, participates through market cycles, and lets time do a large part of the work.</p>
<p>For many Indian investors, SIPs are the first serious step toward long-term wealth creation. Salaried investors like SIPs because the investment can follow the salary cycle. Self-employed investors use SIPs to create structure in irregular income. Parents use SIPs for education goals. Young professionals use SIPs for retirement, travel, or home down payments. The appeal is simple: start with an amount that fits cash flow and keep increasing it as income grows.</p>

<h2>How a SIP actually works</h2>
<p>When you register a SIP, you choose a mutual fund scheme, instalment amount, frequency, start date, and bank mandate. On the selected date, money is debited from your bank account and units of the mutual fund are allotted at the applicable Net Asset Value. If the market is lower, the same amount buys more units. If the market is higher, it buys fewer units. Over time, the investor accumulates units across different market levels.</p>
<p>This process is often called rupee cost averaging. It does not remove risk and it does not guarantee profit. What it does is reduce the pressure of timing every investment. Instead of waiting for the perfect day, the investor follows a rule. This is valuable because many investors delay investing when markets are rising and panic when markets are falling. SIPs make the action automatic, which helps reduce emotional decision-making.</p>
<figure><img src="{$assetBase}/sip-planner-banner.jpg" alt="SIP planner investment illustration" loading="lazy" width="900" height="520"><figcaption>SIPs convert a long-term goal into a repeatable monthly investment habit.</figcaption></figure>

<h2>SIP is a method, not a product</h2>
<p>A common misunderstanding is that SIP itself is an investment product. It is not. SIP is only the route through which you invest into a mutual fund. The underlying fund still matters. A SIP into an aggressive equity fund behaves very differently from a SIP into a short duration debt fund or a hybrid fund. The risk, return expectation, volatility, taxation, and time horizon depend on the scheme category and portfolio.</p>
<p>This distinction matters because investors sometimes say, "SIP is safe." A SIP can be disciplined, convenient, and useful, but the risk comes from the fund selected. Equity SIPs can show negative returns during market corrections. Debt funds can carry interest rate and credit risk. Hybrid funds can fluctuate depending on allocation. The right question is not only whether to start a SIP, but which fund category suits the goal.</p>

<h2>Where SIPs help the most</h2>
<p>SIPs are strongest when the goal is long term and the investor needs a practical way to build the habit. Retirement planning, children's higher education, long-term wealth creation, and goals more than seven years away are natural candidates. Equity-oriented SIPs can be suitable for such goals because longer time frames allow market volatility to work through cycles. The investor gets time to accumulate, review, and rebalance.</p>
<p>SIPs are also useful for people who struggle to save after spending. When the SIP date is placed soon after income arrives, investing becomes the first allocation rather than whatever is left at the end of the month. This small behavioural shift can change outcomes. The investor does not need to feel motivated every month. The system acts on their behalf, and the portfolio grows quietly in the background.</p>

<blockquote>The biggest advantage of a SIP is not that it predicts markets. It removes the need to predict markets before every instalment.</blockquote>

<h2>Choosing the right SIP amount</h2>
<p>The best SIP amount is connected to the goal, not chosen randomly. Start with the future value of the goal, the time available, current savings, expected return assumption, and how much risk is acceptable. A retirement goal may need multiple SIPs across equity and hybrid funds. A medium-term goal may need a lower equity allocation. A near-term goal may not need an equity SIP at all. The amount should be practical and sustainable.</p>
<p>Many investors begin with a small SIP because they are testing the process. That is fine, but the plan should include step-up SIPs. If income rises every year and SIPs remain unchanged for ten years, the investor may fall behind. Increasing SIPs by 5 percent, 10 percent, or a fixed rupee amount every year can make a meaningful difference. The goal is to let savings grow with income before lifestyle inflation takes the entire raise.</p>

<h2>What happens when markets fall?</h2>
<p>Market falls are uncomfortable, but they are part of equity investing. During a correction, SIP instalments buy more units. This can help future returns if the fund recovers and the investor stays invested. The hard part is emotional. Investors see portfolio values fall and wonder whether stopping the SIP will protect them. In many cases, stopping during a decline locks in fear and interrupts the very process designed for volatility.</p>
<p>That does not mean every SIP should continue blindly. If the goal is near, the asset allocation is wrong, the fund has persistent issues, or the investor's financial situation has changed, a review is necessary. But stopping only because markets are down can damage long-term plans. A good SIP review separates market volatility from fund quality and goal suitability.</p>
<figure><img src="{$assetBase}/inflation-calc-chart-data.jpg" alt="Long term investing chart" loading="lazy" width="900" height="520"><figcaption>Regular investing works best when reviewed with time horizon and goal progress, not daily market movement.</figcaption></figure>

<h2>SIP returns need the right expectation</h2>
<p>SIP returns are often misunderstood because investors compare them with point-to-point fund returns. A SIP return is based on multiple cash flows across different dates, so XIRR is usually the better measure. If a fund delivered a strong one-year return, your SIP return may be different because your money entered gradually. This is normal. The SIP experience depends on the sequence of market movement during your investment period.</p>
<p>Expectations should be conservative, especially for goal planning. Assuming very high returns can make the required SIP amount look smaller than it should be. If actual returns are lower, the investor may face a shortfall. It is better to plan with reasonable assumptions, review annually, and increase SIPs when required. A plan that is slightly conservative gives more room for real life.</p>

<h2>Common SIP mistakes</h2>
<p>The first mistake is starting too many SIPs without a portfolio structure. Ten small SIPs across similar funds may look diversified but can create overlap. The second mistake is stopping SIPs too often because of market headlines. The third mistake is choosing funds only by last year's return. The fourth mistake is ignoring asset allocation. The fifth mistake is using equity SIPs for goals that are too close.</p>
<p>Another common mistake is never reviewing SIPs. Automation is useful, but it should not become neglect. A SIP should be checked for fund performance, category suitability, portfolio overlap, expense ratio, manager changes, risk metrics, and goal progress. MyPlexus research tools can help investors and advisors compare funds beyond simple return tables, including composition, risk ratios, and behaviour across periods.</p>

<h2>How to review an existing SIP portfolio</h2>
<p>Begin by listing every SIP, fund name, category, monthly amount, start date, current value, and linked goal. If a SIP has no goal, decide whether it belongs to wealth creation, retirement, or another bucket. Then check whether multiple funds are doing the same job. A portfolio with five large cap funds may not be as diversified as it appears. A portfolio with random sector funds may carry more risk than the investor intended.</p>
<p>Next, compare each fund with its category, benchmark, and risk profile. Do not judge only by one-year return. Look at rolling returns, downside periods, consistency, portfolio quality, and whether the fund still matches the role assigned to it. If a fund needs replacement, switch thoughtfully instead of reacting to short-term rankings. Review the SIP amount too. If the goal is underfunded, increasing the SIP may matter more than changing the fund.</p>

<h2>SIP and financial planning work together</h2>
<p>A SIP is most powerful when it sits inside a broader financial plan. The plan decides the goal, time horizon, risk level, and required investment. The SIP executes the habit. Without a plan, SIPs can become scattered. Without SIPs, a plan can remain theoretical. Together, they create a practical system where money moves toward goals every month with less friction.</p>
<p>If you are beginning, choose one important long-term goal and start there. Keep emergency money separate, avoid investing borrowed money, select a fund category that matches the goal, and set a yearly review date. As income grows, step up the SIP. As the goal comes closer, reduce risk gradually. This simple rhythm can help Indian investors stay focused while markets keep changing around them.</p>

<p><a href="/financial-needs">Read next: Why every Indian needs a financial plan</a></p>
HTML;
    }
}
