<?php


namespace App\Services;


use IntlDateFormatter;
use Symfony\Component\DomCrawler\Crawler;

class ResumeParser
{

    public static function parseGraduation($node): string
    {
        $nodes = $node
            -> filterXPath('//div[@data-qa="resume-block-education"]')
            ->each(function (Crawler $node, $i) {
                return $node
                        -> filterXPath('//div[@data-qa="resume-block-education-name"]/a/span')
                        -> text('') . ' ' . implode($node
                        -> filterXPath('//div[@data-qa="resume-block-education-organization"]/span')
                        -> each(function (Crawler $node, $j) {
                            return $node->text('');
                        }));
            });
        return implode("\n", $nodes);
    }

    public static function parseWorkExperience($node): string
    {
        $works = $node
            -> filterXPath('//div[@data-qa="resume-block-experience"]/div[2]/div/div')
            -> each(function (Crawler $node, $i) {
                $block = $node -> filterXPath('//div/div[2]/div');
                return implode(', ', array(
                    $block -> filterXPath('//div/*/span') -> text(''),
                    $block -> filterXPath('//p[1]') -> text(''),
                    $block -> filterXPath('//p/span[1]') -> text(''),
                    $block
                        -> filterXPath('//div[@data-qa="resume-block-experience-position"]/span')
                        -> text(''),
                    $block
                        -> filterXPath('//div[@data-qa="resume-block-experience-description"]/span')
                        -> text(''),
                ));
            });
        return implode("\n", $works);
    }

    public static function parse(string $html): array
    {
        $crawler = new Crawler($html);
        $empty_array = array(
            'wage' => '',
            'secondName' => '',
            'firstName' => '',
            'patronymic' => '',
            'phone' => '',
            'birthdate' => '',
            'city' => '',
            'graduation' => '',
            'workExperience' => '',
        );
        return $crawler
                -> filterXPath('//div[@class="resume-applicant"]')
                -> each(function (Crawler $node, $i) {
                    $graduation = self::parseGraduation($node);
                    $workExperience = self::parseWorkExperience($node);
                    $fio = explode(" ", $node
                        -> filterXPath('//h2[@data-qa="resume-personal-name"]')
                        -> filterXPath('//span')
                        -> text('')
                    );

                    $secondName = $fio[0] ?? '';
                    $firstName = $fio[1] ?? '';
                    $patronymic = $fio[2] ?? '';

                    $birthdate = $node
                        -> filterXPath('//span[@data-qa="resume-personal-birthday"]')
                        -> text('');

                    $intlFormatter = new IntlDateFormatter(
                        'ru_RU', IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE);
                    $birthdate = $intlFormatter->parse($birthdate);

                    return array(
                        'wage' => $node
                            -> filterXPath('//span[@data-qa="resume-block-salary"]')
                            -> text(''),
                        'secondName' => $secondName,
                        'firstName' => $firstName,
                        'patronymic' => $patronymic,
                        'phone' => $node
                            -> filterXPath('//div[@data-qa="resume-contacts-phone"]/span')
                            -> text(''),
                        'birthdate' => date('Y-m-d', $birthdate),
                        'city' => $node
                            -> filterXPath('//span[@data-qa="resume-personal-address"]')
                            -> text(''),
                        'graduation' => $graduation,
                        'workExperience' => $workExperience,
                    );
            })[0] ?? $empty_array;
    }

}