<?php

namespace Database\Seeders;

use App\Models\CorpusEntry;
use App\Models\FundDictionary;
use App\Models\FundDetail;
use App\Models\FundComposition;
use App\Models\FundCore;
use App\Models\FundMaster;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use App\Models\FundTerm;
use App\Models\FundType;
use App\Models\FundWatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class FundDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment(['production'])) {
            $this->command?->error('FundDemoSeeder cannot run in production.');
            return;
        }

        $now = now();
        $aumDate = Carbon::parse('2022-01-31');
        $prevAumDate = Carbon::parse('2021-12-31');
        $compositionDate = Carbon::parse('2022-01-31');

        $fundTypes = [
            ['name' => 'Equity', 'active_passive' => 'A', 'monthly_performance' => 'Y'],
            ['name' => 'Debt', 'active_passive' => 'P', 'monthly_performance' => 'N'],
            ['name' => 'Hybrid', 'active_passive' => 'A', 'monthly_performance' => 'Y'],
        ];

        $fundTerms = [
            ['term' => 'Short Term', 'days' => 90],
            ['term' => 'Medium Term', 'days' => 365],
            ['term' => 'Long Term', 'days' => 1825],
        ];

        foreach ($fundTypes as $type) {
            FundType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['created_id' => 1, 'updated_id' => 1])
            );
        }

        foreach ($fundTerms as $term) {
            FundTerm::updateOrCreate(
                ['term' => $term['term']],
                array_merge($term, ['created_id' => 1, 'updated_id' => 1])
            );
        }

        $fundTypeMap = FundType::pluck('ft_id', 'name')->all();
        $fundTermMap = FundTerm::pluck('ftm_id', 'term')->all();

        $funds = [
            [
                'fund_name' => 'MyPlexus Large Cap Fund',
                'fund_code' => 'MPXLC001',
                'fund_manager' => 'Aarav Mehta',
                'fund_type_id' => $fundTypeMap['Equity'] ?? 0,
                'fund_term_id' => $fundTermMap['Long Term'] ?? 0,
                'face_value' => 10.0000,
                'risk_free_return' => 6.2500,
                'fund_opened' => '2019-04-01',
                'period' => '5Y',
                'remarks' => 'Demo equity fund for local rendering.',
                'cost' => 1.2500,
                'indices_name' => 'NIFTY 100',
                'fund_house' => 'MyPlex Demo AMC',
                'classification' => 'Large Cap',
                'status' => 1,
            ],
            [
                'fund_name' => 'MyPlexus Short Duration Fund',
                'fund_code' => 'MPXSD001',
                'fund_manager' => 'Neha Iyer',
                'fund_type_id' => $fundTypeMap['Debt'] ?? 0,
                'fund_term_id' => $fundTermMap['Short Term'] ?? 0,
                'face_value' => 10.0000,
                'risk_free_return' => 5.9000,
                'fund_opened' => '2020-08-15',
                'period' => '2Y',
                'remarks' => 'Demo debt fund for AUM and composition views.',
                'cost' => 0.6500,
                'indices_name' => 'CRISIL Short Term Bond',
                'fund_house' => 'MyPlex Demo AMC',
                'classification' => 'Short Duration',
                'status' => 1,
            ],
            [
                'fund_name' => 'MyPlexus Flexi Cap Fund',
                'fund_code' => 'MPXFC001',
                'fund_manager' => 'Rohan Kulkarni',
                'fund_type_id' => $fundTypeMap['Hybrid'] ?? 0,
                'fund_term_id' => $fundTermMap['Medium Term'] ?? 0,
                'face_value' => 10.0000,
                'risk_free_return' => 6.5000,
                'fund_opened' => '2018-11-12',
                'period' => '7Y',
                'remarks' => 'Demo hybrid fund for the local setup.',
                'cost' => 1.0500,
                'indices_name' => 'NIFTY 500',
                'fund_house' => 'MyPlex Demo AMC',
                'classification' => 'Flexi Cap',
                'status' => 1,
            ],
        ];

        $fundRows = [];
        foreach ($funds as $fund) {
            $fundRows[$fund['fund_code']] = FundMaster::updateOrCreate(
                ['fund_code' => $fund['fund_code']],
                array_merge($fund, ['created_id' => 1, 'updated_id' => 1, 'migration_at' => null])
            );
        }

        $classificationProfiles = [
            ['classification' => 'Large Cap', 'type' => 'Equity', 'term' => 'Long Term', 'index' => 'NIFTY 100'],
            ['classification' => 'Flexi Cap', 'type' => 'Equity', 'term' => 'Long Term', 'index' => 'NIFTY 500'],
            ['classification' => 'Mid Cap', 'type' => 'Equity', 'term' => 'Long Term', 'index' => 'NIFTY 500'],
            ['classification' => 'Small Cap', 'type' => 'Equity', 'term' => 'Long Term', 'index' => 'NIFTY 500'],
            ['classification' => 'Value', 'type' => 'Equity', 'term' => 'Long Term', 'index' => 'NIFTY 500'],
            ['classification' => 'Short Duration', 'type' => 'Debt', 'term' => 'Short Term', 'index' => 'CRISIL Short Term Bond'],
            ['classification' => 'Corporate Bond', 'type' => 'Debt', 'term' => 'Medium Term', 'index' => 'CRISIL Short Term Bond'],
            ['classification' => 'Dynamic Bond', 'type' => 'Debt', 'term' => 'Medium Term', 'index' => 'CRISIL Short Term Bond'],
            ['classification' => 'Aggressive Hybrid', 'type' => 'Hybrid', 'term' => 'Medium Term', 'index' => 'NIFTY 500'],
            ['classification' => 'Balanced Advantage', 'type' => 'Hybrid', 'term' => 'Medium Term', 'index' => 'NIFTY 500'],
        ];
        $managerNames = [
            'Aarav Mehta',
            'Neha Iyer',
            'Rohan Kulkarni',
            'Diya Shah',
            'Kabir Rao',
            'Meera Nair',
            'Arjun Malhotra',
            'Ishita Sen',
            'Vikram Joshi',
            'Sana Kapoor',
        ];
        $fundHouses = [
            'MyPlex Alpha AMC',
            'MyPlex Horizon AMC',
            'MyPlex Crest AMC',
            'MyPlex Nova AMC',
            'MyPlex Summit AMC',
        ];

        for ($index = 1; $index <= 97; $index++) {
            $profile = $classificationProfiles[($index - 1) % count($classificationProfiles)];
            $fundCode = 'MPXD' . str_pad((string) $index, 3, '0', STR_PAD_LEFT);
            $fundName = 'MyPlex ' . $profile['classification'] . ' Fund ' . str_pad((string) $index, 2, '0', STR_PAD_LEFT);

            $fundRows[$fundCode] = FundMaster::updateOrCreate(
                ['fund_code' => $fundCode],
                [
                    'fund_name' => $fundName,
                    'fund_code' => $fundCode,
                    'fund_manager' => $managerNames[($index - 1) % count($managerNames)],
                    'fund_type_id' => $fundTypeMap[$profile['type']] ?? 0,
                    'fund_term_id' => $fundTermMap[$profile['term']] ?? 0,
                    'face_value' => 10.0000,
                    'risk_free_return' => 5.75 + (($index % 8) * 0.15),
                    'fund_opened' => Carbon::parse('2014-01-01')->addMonths($index)->toDateString(),
                    'period' => (($index % 8) + 3) . 'Y',
                    'remarks' => 'Generated local demo fund for heatmap testing.',
                    'cost' => 0.45 + (($index % 12) * 0.08),
                    'indices_name' => $profile['index'],
                    'fund_house' => $fundHouses[($index - 1) % count($fundHouses)],
                    'classification' => $profile['classification'],
                    'status' => 1,
                    'created_id' => 1,
                    'updated_id' => 1,
                    'migration_at' => null,
                ]
            );
        }

        foreach ($fundRows as $fundCode => $fund) {
            FundCore::updateOrCreate(
                ['fund_id' => $fund->fund_id],
                [
                    'fund_id' => $fund->fund_id,
                    'cor' => match ($fundCode) {
                        'MPXLC001' => '0.82',
                        'MPXSD001' => '0.41',
                        default => '0.67',
                    },
                    'created_id' => 1,
                    'updated_id' => 1,
                ]
            );
        }

        $indicesRows = [
            ['name' => 'NIFTY 100', 'corelation' => 'NIFTY 100 TRI', 'status' => 1],
            ['name' => 'CRISIL Short Term Bond', 'corelation' => 'CRISIL Short Term Bond TRI', 'status' => 1],
            ['name' => 'NIFTY 500', 'corelation' => 'NIFTY 500 TRI', 'status' => 1],
        ];

        foreach ($indicesRows as $row) {
            IndicesMaster::updateOrCreate(
                ['name' => $row['name']],
                array_merge($row, ['created_id' => 1, 'updated_id' => 1])
            );
        }

        $indexDates = [
            '2021-12-31' => ['NIFTY 100 TRI' => 15678.44, 'CRISIL Short Term Bond TRI' => 2045.12, 'NIFTY 500 TRI' => 22110.75],
            '2022-01-31' => ['NIFTY 100 TRI' => 15990.27, 'CRISIL Short Term Bond TRI' => 2056.88, 'NIFTY 500 TRI' => 22875.31],
        ];

        foreach ($indexDates as $entryDate => $values) {
            foreach ($values as $indexName => $closingValue) {
                IndicesDetail::updateOrCreate(
                    [
                        'name' => $indexName,
                        'entry_date' => $entryDate,
                    ],
                    [
                        'name' => $indexName,
                        'entry_date' => $entryDate,
                        'closing_value' => $closingValue,
                        'holiday' => 0,
                        'percentage_change' => 0.00,
                        'publish' => $entryDate === '2022-01-31' ? 'y' : 'n',
                        'created_id' => 1,
                        'updated_id' => 1,
                    ]
                );
            }
        }

        $generatedIndexDates = [
            '2026-01-01' => ['NIFTY 100 TRI' => 24840.20, 'CRISIL Short Term Bond TRI' => 2388.40, 'NIFTY 500 TRI' => 35620.80],
            '2026-02-01' => ['NIFTY 100 TRI' => 25215.70, 'CRISIL Short Term Bond TRI' => 2401.15, 'NIFTY 500 TRI' => 36148.30],
            '2026-03-01' => ['NIFTY 100 TRI' => 24792.10, 'CRISIL Short Term Bond TRI' => 2414.85, 'NIFTY 500 TRI' => 35488.60],
            '2026-04-01' => ['NIFTY 100 TRI' => 25590.45, 'CRISIL Short Term Bond TRI' => 2428.25, 'NIFTY 500 TRI' => 36795.20],
            '2026-05-01' => ['NIFTY 100 TRI' => 26118.80, 'CRISIL Short Term Bond TRI' => 2441.90, 'NIFTY 500 TRI' => 37582.40],
            '2026-06-01' => ['NIFTY 100 TRI' => 25874.35, 'CRISIL Short Term Bond TRI' => 2455.65, 'NIFTY 500 TRI' => 37124.75],
        ];

        foreach ($generatedIndexDates as $entryDate => $values) {
            foreach ($values as $indexName => $closingValue) {
                IndicesDetail::updateOrCreate(
                    [
                        'name' => $indexName,
                        'entry_date' => $entryDate,
                    ],
                    [
                        'name' => $indexName,
                        'entry_date' => $entryDate,
                        'closing_value' => $closingValue,
                        'holiday' => 0,
                        'percentage_change' => 0.00,
                        'publish' => 'y',
                        'created_id' => 1,
                        'updated_id' => 1,
                        'migration_at' => null,
                    ]
                );
            }
        }

        $fundDetailRows = [
            ['fund_code' => 'MPXLC001', 'dates' => ['2021-12-31' => [149.72, 'n'], '2022-01-31' => [152.68, 'y']]],
            ['fund_code' => 'MPXSD001', 'dates' => ['2021-12-31' => [24.11, 'n'], '2022-01-31' => [24.48, 'y']]],
            ['fund_code' => 'MPXFC001', 'dates' => ['2021-12-31' => [88.36, 'n'], '2022-01-31' => [90.74, 'y']]],
        ];

        foreach ($fundDetailRows as $row) {
            foreach ($row['dates'] as $entryDate => [$closingNav, $publish]) {
                FundDetail::updateOrCreate(
                    [
                        'fund_code' => $row['fund_code'],
                        'entry_date' => $entryDate,
                    ],
                    [
                        'fund_code' => $row['fund_code'],
                        'entry_date' => $entryDate,
                        'closing_nav' => $closingNav,
                        'holiday' => 0,
                        'percentage_change' => 0.00,
                        'publish' => $publish,
                        'created_id' => 1,
                        'updated_id' => 1,
                    ]
                );
            }
        }

        $aumRows = [
            [
                'fund_code' => 'MPXLC001',
                'current' => 1540.25,
                'previous' => 1498.60,
            ],
            [
                'fund_code' => 'MPXSD001',
                'current' => 980.75,
                'previous' => 1002.10,
            ],
            [
                'fund_code' => 'MPXFC001',
                'current' => 2125.90,
                'previous' => 2088.40,
            ],
        ];

        foreach ($aumRows as $aumRow) {
            $delta = $aumRow['current'] - $aumRow['previous'];
            $pct = $aumRow['previous'] > 0 ? round(($delta / $aumRow['previous']) * 100, 2) : null;

            CorpusEntry::updateOrCreate(
                [
                    'fund_code' => $aumRow['fund_code'],
                    'entry_date' => $prevAumDate->toDateString(),
                ],
                [
                    'fund_code' => $aumRow['fund_code'],
                    'entry_date' => $prevAumDate->toDateString(),
                    'corpus_entry' => $aumRow['previous'],
                    'percentage_change' => null,
                    'corpus_change' => null,
                    'publish' => 'n',
                    'created_id' => 1,
                    'updated_id' => 1,
                ]
            );

            CorpusEntry::updateOrCreate(
                [
                    'fund_code' => $aumRow['fund_code'],
                    'entry_date' => $aumDate->toDateString(),
                ],
                [
                    'fund_code' => $aumRow['fund_code'],
                    'entry_date' => $aumDate->toDateString(),
                    'corpus_entry' => $aumRow['current'],
                    'percentage_change' => $pct,
                    'corpus_change' => round($delta, 2),
                    'publish' => 'y',
                    'created_id' => 1,
                    'updated_id' => 1,
                ]
            );
        }

        $navDates = [
            '2026-01-01',
            '2026-02-01',
            '2026-03-01',
            '2026-04-01',
            '2026-05-01',
            '2026-06-01',
        ];

        foreach (array_values($fundRows) as $index => $fund) {
            $baseNav = 18 + (($index * 13) % 135) + (($index % 7) * 0.37);
            $previousNav = null;

            foreach ($navDates as $monthIndex => $entryDate) {
                $direction = (($index + $monthIndex) % 5) < 3 ? 1 : -1;
                $movementPercent = $direction * (0.55 + ((($index * 7) + ($monthIndex * 3)) % 48) / 10);
                $closingNav = $previousNav === null
                    ? round($baseNav, 2)
                    : round(max(5, $previousNav * (1 + ($movementPercent / 100))), 2);
                $percentageChange = $previousNav && $previousNav != 0.0
                    ? round((($closingNav - $previousNav) / $previousNav) * 100, 2)
                    : 0.0;

                FundDetail::updateOrCreate(
                    [
                        'fund_code' => $fund->fund_code,
                        'entry_date' => $entryDate,
                    ],
                    [
                        'fund_code' => $fund->fund_code,
                        'entry_date' => $entryDate,
                        'closing_nav' => $closingNav,
                        'holiday' => 0,
                        'percentage_change' => $percentageChange,
                        'publish' => 'y',
                        'created_id' => 1,
                        'updated_id' => 1,
                        'migration_at' => null,
                    ]
                );

                $previousNav = $closingNav;
            }

            $previousCorpus = round(320 + (($index * 173) % 9200) + (($index % 9) * 41.75), 2);
            $corpusDirection = $index % 4 === 0 ? -1 : 1;
            $corpusMovement = $corpusDirection * (18 + (($index * 29) % 310));
            $currentCorpus = round(max(100, $previousCorpus + $corpusMovement), 2);
            $corpusPercentage = round((($currentCorpus - $previousCorpus) / $previousCorpus) * 100, 2);

            CorpusEntry::updateOrCreate(
                [
                    'fund_code' => $fund->fund_code,
                    'entry_date' => '2026-05-01',
                ],
                [
                    'fund_code' => $fund->fund_code,
                    'entry_date' => '2026-05-01',
                    'corpus_entry' => $previousCorpus,
                    'percentage_change' => 0.0,
                    'corpus_change' => 0.0,
                    'publish' => 'y',
                    'created_id' => 1,
                    'updated_id' => 1,
                    'migration_at' => null,
                ]
            );

            CorpusEntry::updateOrCreate(
                [
                    'fund_code' => $fund->fund_code,
                    'entry_date' => '2026-06-01',
                ],
                [
                    'fund_code' => $fund->fund_code,
                    'entry_date' => '2026-06-01',
                    'corpus_entry' => $currentCorpus,
                    'percentage_change' => $corpusPercentage,
                    'corpus_change' => round($currentCorpus - $previousCorpus, 2),
                    'publish' => 'y',
                    'created_id' => 1,
                    'updated_id' => 1,
                    'migration_at' => null,
                ]
            );
        }

        $compositionRows = [
            ['fund_code' => 'MPXLC001', 'scrip_name' => 'HDFC Bank', 'industry' => 'Banking', 'category' => 'Equity', 'content_per' => 11.40, 'amount' => 175.60, 'no_of_shares' => 120000, 'indices_per' => 10.85],
            ['fund_code' => 'MPXLC001', 'scrip_name' => 'Reliance Industries', 'industry' => 'Energy', 'category' => 'Equity', 'content_per' => 9.85, 'amount' => 151.90, 'no_of_shares' => 54000, 'indices_per' => 8.76],
            ['fund_code' => 'MPXSD001', 'scrip_name' => 'T-Bill', 'industry' => 'Government Securities', 'category' => 'Debt', 'content_per' => 18.75, 'amount' => 183.90, 'no_of_shares' => 1, 'indices_per' => 17.30],
            ['fund_code' => 'MPXSD001', 'scrip_name' => 'AAA PSU Bond', 'industry' => 'Bonds', 'category' => 'Debt', 'content_per' => 14.20, 'amount' => 139.20, 'no_of_shares' => 1, 'indices_per' => 13.10],
            ['fund_code' => 'MPXFC001', 'scrip_name' => 'ICICI Bank', 'industry' => 'Banking', 'category' => 'Equity', 'content_per' => 10.90, 'amount' => 231.60, 'no_of_shares' => 84000, 'indices_per' => 9.95],
            ['fund_code' => 'MPXFC001', 'scrip_name' => 'Infosys', 'industry' => 'IT', 'category' => 'Equity', 'content_per' => 8.30, 'amount' => 176.40, 'no_of_shares' => 47000, 'indices_per' => 7.15],
        ];

        foreach ($compositionRows as $row) {
            FundComposition::updateOrCreate(
                [
                    'entry_date' => $compositionDate->toDateString(),
                    'fund_code' => $row['fund_code'],
                    'scrip_name' => $row['scrip_name'],
                ],
                [
                    'entry_date' => $compositionDate->toDateString(),
                    'fund_code' => $row['fund_code'],
                    'scrip_name' => $row['scrip_name'],
                    'industry' => $row['industry'],
                    'category' => $row['category'],
                    'content_per' => $row['content_per'],
                    'amount' => $row['amount'],
                    'no_of_shares' => $row['no_of_shares'],
                    'indices_per' => $row['indices_per'],
                    'publish' => 'y',
                    'created_id' => 1,
                    'updated_id' => 1,
                ]
            );
        }

        $watchRows = [
            ['title' => 'Large Cap Fund note', 'description' => 'Demo commentary for the large cap fund.'],
            ['title' => 'Short Duration Fund note', 'description' => 'Demo commentary for the short duration fund.'],
            ['title' => 'Flexi Cap Fund note', 'description' => 'Demo commentary for the flexi cap fund.'],
        ];

        foreach ($watchRows as $index => $row) {
            FundWatch::updateOrCreate(
                ['title' => $row['title']],
                [
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'file' => null,
                    'c_order' => $index + 1,
                    'status' => 1,
                    'created_id' => 1,
                    'updated_id' => 1,
                    'migration_at' => null,
                ]
            );
        }

        $dictionaryRows = [
            ['title' => 'AUM', 'description' => 'Assets Under Management for a fund.'],
            ['title' => 'NAV', 'description' => 'Net Asset Value of a mutual fund scheme.'],
            ['title' => 'TER', 'description' => 'Total Expense Ratio charged by the scheme.'],
            ['title' => 'CAGR', 'description' => 'Compound Annual Growth Rate.'],
            ['title' => 'Benchmark', 'description' => 'The market index used as a performance reference.'],
        ];

        foreach ($dictionaryRows as $row) {
            FundDictionary::updateOrCreate(
                ['title' => $row['title']],
                [
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'status' => 1,
                    'created_id' => 1,
                    'updated_id' => 1,
                    'migration_at' => null,
                ]
            );
        }

        $this->command?->info('Fund demo content seeded with 100 heatmap funds.');
        $this->command?->line('Fund codes: MPXLC001, MPXSD001, MPXFC001, MPXD001-MPXD097');
        $this->command?->line('Latest NAV and AUM date: 2026-06-01');
        $this->command?->line('Composition date: ' . $compositionDate->toDateString());
    }
}
