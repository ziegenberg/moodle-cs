<?php

// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace MoodleHQ\MoodleCS\moodle\Tests;

/**
 * Test the BoilerplateCommentSniff sniff.
 *
 * @copyright  2022 onwards Eloy Lafuente (stronk7) {@link https://stronk7.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @covers \MoodleHQ\MoodleCS\moodle\Sniffs\Files\BoilerplateCommentSniff
 */
class FilesBoilerPlateCommentTest extends MoodleCSBaseTestCase
{
    public function testMoodleFilesBoilerplateCommentOk() {
        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/ok.php');

        // Define expected results (errors and warnings). Format, array of:
        // - line => number of problems,  or
        // - line => array of contents for message / source problem matching.
        // - line => string of contents for message / source problem matching (only 1).
        $this->setErrors([]);
        $this->setWarnings([]);

        $this->verifyCsResults();

        // Also try with the <?php line having some // phpcs:xxxx annotations.
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/ok2.php');

        $this->setErrors([]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    public function testMoodleFilesBoilerplateCommentNoPHP() {
        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/nophp.php');

        $this->setErrors([
            1 => 'moodle.Files.BoilerplateComment.NoPHP',
        ]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    public function testMoodleFilesBoilerplateCommentBlank() {
        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/blank.php');

        $this->setErrors([
            2 => 'followed by exactly one newline',
        ]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    public function testMoodleFilesBoilerplateCommentShort() {
        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/short.php');

        $this->setErrors([
            14 => 'FileTooShort',
        ]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    public function testMoodleFilesBoilerplateCommentShortEmpty() {
        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/short_empty.php');

        $this->setErrors([
            1 => 'FileTooShort',
        ]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    public function testMoodleFilesBoilerplateCommentWrongLine() {
        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/wrongline.php');

        $this->setErrors([
            6 => 'version 3',
            11 => 'FITNESS',
        ]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    public function testMoodleFilesBoilerplateCommentGnuHttp() {

        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/gnu_http.php');

        $this->setErrors([]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }

    /**
     * Assert that www.gnu.org can be referred to via https URL in the boilerplate.
     */
    public function testMoodleFilesBoilerplateCommentGnuHttps() {

        $this->setStandard('moodle');
        $this->setSniff('moodle.Files.BoilerplateComment');
        $this->setFixture(__DIR__ . '/fixtures/files/boilerplatecomment/gnu_https.php');

        $this->setErrors([]);
        $this->setWarnings([]);

        $this->verifyCsResults();
    }
}
