<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LocalDemoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment(['production'])) {
            return;
        }

        $now = now();

        $pages = [
            ['page_id' => 6, 'title' => 'Monthly Ranking', 'slug' => 'monthly-ranking'],
            ['page_id' => 7, 'title' => 'Fund Portfolio', 'slug' => 'fund-portfolio'],
            ['page_id' => 8, 'title' => 'Composition Snapshot', 'slug' => 'composition-snapshot'],
            ['page_id' => 9, 'title' => 'Monthly Snapshot', 'slug' => 'monthly-snapshot'],
            ['page_id' => 10, 'title' => 'Weekly Snapshot', 'slug' => 'weekly-snapshot'],
            ['page_id' => 18, 'title' => 'Fund Performance', 'slug' => 'fund-performance'],
            ['page_id' => 19, 'title' => 'Compare Scheme', 'slug' => 'compare-scheme'],
            ['page_id' => 20, 'title' => 'Performance Snapshot', 'slug' => 'performance-snapshot'],
            ['page_id' => 21, 'title' => 'Mutual Fund Taxation', 'slug' => 'mutual-fund-taxation'],
            ['page_id' => 22, 'title' => 'Mutual Fund Classifications', 'slug' => 'mutual-fund-classifications'],
            ['page_id' => 23, 'title' => 'Know The Ratio', 'slug' => 'know-the-ratio'],
            ['page_id' => 24, 'title' => 'Thoughts And Opinion On Funds', 'slug' => 'thoughts-and-opinion-on-funds'],
            ['page_id' => 25, 'title' => 'Paathshaala', 'slug' => 'paathshaala'],
            ['page_id' => 26, 'title' => 'FAQ', 'slug' => 'faq'],
            ['page_id' => 27, 'title' => 'In The News', 'slug' => 'in-the-news'],
            ['page_id' => 29, 'title' => 'Pentatec Filter', 'slug' => 'pentatec-filter'],
            ['page_id' => 31, 'title' => 'Meet The Fund Man', 'slug' => 'meet-the-fund-man'],
            ['page_id' => 32, 'title' => 'Know Your Scheme', 'slug' => 'know-your-scheme'],
            ['page_id' => 44, 'title' => 'Calculator', 'slug' => 'calculator'],
            ['page_id' => 48, 'title' => 'Founder', 'slug' => 'founder'],
            ['page_id' => 51, 'title' => 'Fund Man Details', 'slug' => 'fund-man-details'],
            ['page_id' => 52, 'title' => 'Shridatta Bhandwaldar', 'slug' => 'shridatta-bhandwaldar'],
            ['page_id' => 53, 'title' => 'Shreyas Devalkar', 'slug' => 'shreyas-devalkar'],
            ['page_id' => 54, 'title' => 'Aniruddha Naha', 'slug' => 'aniruddha-naha'],
            ['page_id' => 55, 'title' => 'Sanjay Chawla', 'slug' => 'sanjay-chawla'],
            ['page_id' => 56, 'title' => 'Return Calculator', 'slug' => 'return-calculator'],
            ['page_id' => 57, 'title' => 'Volatility Calculator', 'slug' => 'volatility-calculator'],
        ];

        $pageRows = array_map(function ($page) use ($now) {
            return [
                'page_id' => $page['page_id'],
                'title' => $page['title'],
                'slug' => $page['slug'],
                'descp' => '<p>Local demo content for ' . $page['title'] . '.</p>',
                'media_id' => 0,
                'parent' => 0,
                'template_id' => 1,
                'is_private' => 1,
                'note' => 'Seeded for local demo use.',
                'meta_title' => $page['title'],
                'meta_key' => '',
                'meta_descp' => 'Local demo page for ' . $page['title'] . '.',
                'c_order' => 0,
                'status' => 1,
                'updated_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $pages);

        DB::table('pages')->upsert($pageRows, ['page_id'], [
            'title', 'slug', 'descp', 'media_id', 'parent', 'template_id', 'is_private',
            'note', 'meta_title', 'meta_key', 'meta_descp', 'c_order', 'status',
            'updated_id', 'updated_at'
        ]);

        if (Schema::hasTable('new_from_myplexus')) {
            DB::table('new_from_myplexus')->truncate();
            DB::table('new_from_myplexus')->insert([
                ['type_id' => 'Insight', 'title' => 'Local market insight demo item', 'link' => 'https://example.com/insight', 'created_at' => $now, 'updated_at' => $now],
                ['type_id' => 'Update', 'title' => 'Local platform update demo item', 'link' => 'https://example.com/update', 'created_at' => $now, 'updated_at' => $now],
                ['type_id' => 'Research', 'title' => 'Local research highlight demo item', 'link' => 'https://example.com/research', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (Schema::hasTable('teams')) {
            DB::table('teams')->updateOrInsert(
                ['team_id' => 1],
                ['name' => 'Local Demo Team Member', 'media_id' => 0, 'designation' => 'Research Analyst', 'linkedin_link' => 'https://example.com/team', 'c_order' => 1, 'status' => 1, 'updated_id' => 1, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        if (Schema::hasTable('faq')) {
            DB::table('faq')->updateOrInsert(
                ['faq_id' => 1],
                ['title' => 'What is included in the local demo?', 'descp' => 'This local setup seeds enough content for core frontend routes to render.', 'cc_id' => 1, 'c_order' => 1, 'status' => 1, 'updated_id' => 1, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        if (Schema::hasTable('know_the_ratio')) {
            DB::table('know_the_ratio')->updateOrInsert(
                ['ktr_id' => 1],
                ['title' => 'Expense Ratio', 'description' => 'A local demo entry explaining expense ratio.', 'media_id' => 0, 'status' => 1, 'c_order' => 1, 'created_id' => 1, 'updated_id' => 1, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        if (Schema::hasTable('fund_suggestion')) {
            DB::table('fund_suggestion')->updateOrInsert(
                ['fs_id' => 1],
                ['title' => 'Demo fund note', 'description' => 'A local placeholder for thoughts and opinions on funds.', 'file' => null, 'c_order' => 1, 'status' => 1, 'created_id' => 1, 'updated_id' => 1, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        if (Schema::hasTable('news')) {
            DB::table('news')->updateOrInsert(
                ['n_id' => 1],
                ['title' => 'Local demo news item', 'slug' => 'local-demo-news-item', 'description' => 'A seeded news item for local testing.', 'media_type' => '', 'image' => null, 'video_from' => '', 'video_data' => null, 'video_image' => null, 'news_source' => 'Local Demo', 'news_source_link' => 'https://example.com/news', 'status' => 1, 'created_id' => 1, 'updated_id' => 1, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        if (Schema::hasTable('fund_man')) {
            DB::table('fund_man')->updateOrInsert(
                ['fm_id' => 1],
                [
                    'name' => 'Local Demo Fund Manager',
                    'slug' => 'local-demo-fund-manager',
                    'media_id' => 0,
                    'profile_picture' => null,
                    'designation' => 'Chief Investment Officer',
                    'company_name' => 'MyPlex Demo Asset Management',
                    'synopsis' => 'Local demo synopsis for a fund manager profile.',
                    'description' => '<p>This profile was seeded to make the fund manager page render locally.</p>',
                    'disclaimer' => null,
                    'disclaimer_note' => 'Local demo disclaimer note.',
                    'status' => 1,
                    'created_id' => 1,
                    'updated_id' => 1,
                    'migration_at' => null,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        $this->command->info('Local demo content seeded!');
    }
}
