<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Diatheke;

/**
 * Description of Range
 *
 * @author krillzip
 */
class ReferenceBuilder {
    
    const _GENESIS = 'Gen';
    const _EXODUS = 'Exod';
    const _LEVITICUS = 'Lev';
    const _NUMBERS = 'Num';
    const _DEUTERONOMY = 'Deut';
    const _JOSHUA = 'Josh';
    const _JUDGES = 'Judg';
    const _RUTH = 'Ruth';
    const _1SAMUEL = '1Sam';
    const _2SAMUEL = '2Sam';
    const _1KINGS = '1Kgs';
    const _2KINGS = '2Kgs';
    const _1CHRONICLES = '1Chr';
    const _2CHRONICLES = '2Chr';
    const _EZRA = 'Ezra';
    const _NEHEMIA = 'Neh';
    const _ESTHER = 'Esth';
    const _JOB = 'Job';
    const _PSALMS = 'Ps';
    const _PROVERBS = 'Prov';
    const _ECCLESIASTES = 'Eccl';
    const _SONG_OF_SOLOMON = 'Song';
    const _ISAIAH = 'Isa';
    const _JEREMIAH = 'Jer';
    const _LAMENTATIONS = 'Lam';
    const _EZEKIEL = 'Ezek';
    const _DANIEL = 'Dan';
    const _HOSEA = 'Hos';
    const _JOEL = 'Joel';
    const _AMOS = 'Amos';
    const _OBADIAH = 'Obad';
    const _JONAH = 'Jonah';
    const _MICAH = 'Mic';
    const _NAHUM = 'Nah';
    const _HABAKKUK = 'Hab';
    const _ZEPHANIAH = 'Zeph';
    const _HAGGAI = 'Hag';
    const _ZECHARIAH = 'Zech';
    const _MALACHI = 'Mal';

    const _MATTHEW = 'Matt';
    const _MARK = 'Mark';
    const _LUKE = 'Luke';
    const _JOHN = 'John';
    const _ACTS = 'Acts';
    const _ROMANS = 'Rom';
    const _1CHORINTIANS = '1Cor';
    const _2CHORINTIANS = '2Cor';
    const _GALATIANS = 'Gal';
    const _EPHESIANS = 'Eph';
    const _PHILIPPIANS = 'Phil';
    const _COLOSSIANS = 'Col';
    const _1THESSALONIANS = '1Thess';
    const _2THESSALONIANS = '2Thess';
    const _1THIMOTY = '1Tim';
    const _2THIMOTY = '2Tim';
    const _TITUS = 'Titus';
    const _PHILEMON = 'Phlm';
    const _HEBREWS = 'Heb';
    const _JAMES = 'Jas';
    const _1PETER = '1Pet';
    const _2PETER = '2Pet';
    const _1JOHN = '1John';
    const _2JOHN = '2John';
    const _3JOHN = '3John';
    const _JUDE = 'Jude';
    const _REVELATION = 'Rev';

    protected $book = null;
    protected $reference = null;
    protected $to = null;
    protected $books = array(
        'Gen', 'Exod', 'Lev', 'Num', 'Deut', 'Josh', 'Judg', 'Ruth', '1Sam',
        '2Sam', '1Kgs', '2Kgs', '1Chr', '2Chr', 'Ezra', 'Neh', 'Esth', 'Job',
        'Ps', 'Prov', 'Eccl', 'Song', 'Isa', 'Jer', 'Lam', 'Ezek', 'Dan', 'Hos',
        'Joel', 'Amos', 'Obad', 'Jonah', 'Mic', 'Nah', 'Hab', 'Zeph', 'Hag',
        'Zech', 'Mal', 'Matt', 'Mark', 'Luke', 'John', 'Acts', 'Rom', '1Cor',
        '2Cor', 'Gal', 'Eph', 'Phil', 'Col', '1Thess', '2Thess', '1Tim', '2Tim',
        'Titus', 'Phlm', 'Heb', 'Jas', '1Pet', '2Pet', '1John', '2John',
        '3John', 'Jude', 'Rev',
    );

    public function reference($book, $chapter, $verse) {

        if (!in_array($book, $this->books)) {
            throw new Exception\ReferenceBuilderException('Not valid bible book!');
        }

        if ((is_int($chapter) && $chapter > 0)) {
            throw new Exception\ReferenceBuilderException('Chapter not integer or zero!');
        }

        if ((is_int($verse) && $verse > 0)) {
            throw new Exception\ReferenceBuilderException('Verse not integer or zero!');
        }

        $this->book = $name;
        $this->reference = (object) array(
                    'chapter' => $chapter,
                    'verse' => $verse,
        );

        return $this;
    }

    public function to($chapter, $verse) {

        if (!isset($this->reference)) {
            throw new Exception\ReferenceBuilderException('Reference not set!');
        }

        if ((is_int($chapter) && $chapter > 0)) {
            throw new Exception\ReferenceBuilderException('Chapter not integer or zero!');
        }

        if ((is_int($verse) && $verse > 0)) {
            throw new Exception\ReferenceBuilderException('Verse not integer or zero!');
        }

        $this->to = (object) array(
                    'chapter' => $chapter,
                    'verse' => $verse,
        );

        return $this;
    }

    public function __toString() {
        return $book .
                ' ' .
                $this->reference->chapter .
                ':' .
                $this->reference->verse .
                (isset($this->to) ?
                        $this->to->chapter .
                        ':' .
                        $this->to->verse : ''
                );
    }

}

