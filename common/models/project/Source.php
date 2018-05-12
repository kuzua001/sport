<?php


namespace common\models\project;


class Source {
    /** @var string */
    private $name;

    /** @var integer */
    private $sourceId;

    /** @var Source[] */
    private static $instances = [];

    public const SOURCE_ICOBAZAAR = 1;

    protected static $availableSources = [
        self::SOURCE_ICOBAZAAR => 'icobazaar'
    ];

    protected function __construct(int $type) {
        if (isset(self::$availableSources[$type])) {
            $this->name = self::$availableSources[$type];
            $this->sourceId = $type;
        } else {
            throw new \Exception('Unknown source type provided'); // todo chcnge for custom excoption
        }
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSourceId(): int {
        return $this->sourceId;
    }

    /**
     * @param int $type
     *
     * @return Source
     * @throws \Exception
     */
    public static function getInstance(int $type): self {
        if (!isset(self::$instances[$type])) {
            self::$instances[$type] = new Source($type);
        }

        return self::$instances[$type];
    }
}