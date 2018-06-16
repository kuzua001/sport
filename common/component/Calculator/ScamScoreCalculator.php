<?php

namespace common\component\Calculator;

use common\models\project\Tournament;

class ScamScoreCalculator {
    protected $processors;

    public const WHITEPAPER = 'has_whitepaper';
    public const BITCOINTALK = 'has_bitcointalk';
    public const GITHUB = 'has_github';
    public const REG_COUNTRY = 'has_reg_country';
    public const PROTOTYPE = 'has_prototype';
    public const KYC_Y_N = 'has_kyc_y_n';
    public const PRE_ICO = 'has_pre_ico';
    public const RESTRICTED_AREAS = 'has_restricted_areas';

    public const TEAM = 'count_team';
    public const ADVISOR_NUMBER = 'has_advisor_number';
    public const LINKS_TOP_MANAGEMENT = 'has_links_top_management';
    public const LINKS_ADVISORS = 'has_links_advisors';
    public const ICO_LENGTH_MONTH = 'less_ico_length_month';
    public const AMOUNT_COLLECTED_1MLN = 'less_amount_collected_1mln';

    public const MEDIUM = 'has_medium';
    public const REDDIT = 'has_reddit';
    public const TWITTER = 'has_twitter';
    public const FACEBOOK = 'has_facebook';
    public const TELEGRAM = 'has_telegram';
    public const INSTAGRAM = 'has_instagram';
    public const LINKEDIN = 'has_linkedin';
    public const YOUTUBE = 'has_youtube';
    public const SLACK = 'has_slack';

    protected static $variablesConfig = [
        self::WHITEPAPER => [],
        self::BITCOINTALK => [],
        self::GITHUB => [],
        self::TEAM => ['weight' => -0.5, 'point' => 2],
        self::LINKS_TOP_MANAGEMENT => ['weight' => 1],
        self::AMOUNT_COLLECTED_1MLN => ['point' => 1e6],
        self::MEDIUM => ['weight' => -2],
        self::REDDIT => ['weight' => -2],
        self::TWITTER => ['weight' => -2],
        self::FACEBOOK => ['weight' => -2],
        self::TELEGRAM => ['weight' => -2],
        self::INSTAGRAM => ['weight' => -1],
        self::LINKEDIN => ['weight' => -1],
        self::YOUTUBE => ['weight' => -1],
        self::SLACK => ['weight' => -1],
    ];

    /** @var Tournament */
    private $project;

    public function __construct(Tournament $project) {
        $this->project = $project;

        $this->processors = [
            'has_' => function($data, $key, $config) {
                $val = ($config['inverse'] ?? false) ? (1 - (int) empty($data[$key])) : (int) empty($data[$key]);
                $result = ($config['weight'] ?? 10) * $val;
                echo 'Has ' . $key . ' ' . json_encode($config) . ' is: ' . $result . PHP_EOL;
                return $result;
            },
            'count_' => function($data, $key, $config) {
                $result =  count($data[$key] ?? []) * $config['weight'];
                echo 'Count ' . $key . ' ' . json_encode($config) . ' is: ' . $result . PHP_EOL;
                return $result;
            },
            'contains_' => function($data, $key, $config) {
                $result = strpos($data[$key], $config['search']) !== false;
                echo 'Contains ' . $key . ' ' . json_encode($config) . ' is: ' . $result . PHP_EOL;
                return $result;
            },
            'value_' => function($data, $key, $config) {
                echo 'Value ' . json_encode($config) . 'is: ' . $data[$key];
                return $data[$key];
            },
            'less_' => function($data, $key, $config) {
                $result = (int)($data[$key] < $config['point']) * ($config['weight'] ?? 1);
                echo 'Less ' . $key . ' ' . json_encode($config) . ' is: ' . $result . PHP_EOL;
                return $result;
            },
            'more_' => function($data, $key, $config) {
                $result = (int)($data[$key] > $config['point']) * ($config['weight'] ?? 1);
                echo 'More ' . $key . ' ' . json_encode($config) . ' is: ' . $result . PHP_EOL;
                return $result;
            },
        ];
    }

    private function calcVariableInfluence($name, $data, $config) {
        foreach ($this->processors as $prefix => $processor) {
            if (strpos($name, $prefix) === 0) {
                $realName = str_replace($prefix, '', $name);
                return $processor($data, $realName, $config);
            }
        }
    }

    public function calcScore(): array {
        $sum = 0;
        ob_start();
        foreach (self::$variablesConfig as $varName => $config) {
            $sum += $this->calcVariableInfluence($varName, $this->project->project_data, $config);
        }
        $comment = ob_get_contents();
        ob_end_clean();

        return [
            'score' => $sum,
            'comment' => $comment,
        ];
    }
}