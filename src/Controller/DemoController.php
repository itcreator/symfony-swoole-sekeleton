<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DemoController
{
    /**
     * @param int $x1 point #1
     * @param int $y1 point #1
     * @param int $x2 point #2
     * @param int $y2 point #2
     * @param int $x3 point #3
     * @param int $y3 point #3
     * @return float
     */
    public function avgDistance(int $x1, int $y1, int $x2, int $y2, int $x3, int $y3): float
    {
        $distance = static function (int $x1, int $y1, int $x2, int $y2) : float {
            return sqrt(($x1  - $x2) ** 2 + ($y1  - $y2) ** 2);
        };

        $dist1 = $distance($x1, $y1, $x2, $y2);
        $dist2 = $distance($x2, $y2, $x3, $y3);
        $dist3 = $distance($x3, $y3, $x1, $y1);


        return ($dist1 + $dist2 + $dist3) / 3;
    }


    /**
     * @param string $str
     * @return bool
     */
    public function isAlmostPalindrome(string  $str) : bool
    {
        $len = strlen($str);

        //split and revert end of string
        $begin = substr($str, 0, round($len / 2));
        $end = strrev(substr($str, floor($len / 2)));

        // is palindrome
        if ($begin === $end) {
            return true;
        }

        //check if it is almost palindrome
        $substrLen = strlen($begin);
        $diffCount = 0;
        for ($i = 0; $i < $substrLen; $i ++) {
            if ($begin[$i] !== $end[$i]) {
                ++ $diffCount;
            }
            if ($diffCount > 1) {
                break;
            }
        }

        return $diffCount <= 1;
    }

    /**
     * @param array{int, int}|int[] $numbers
     * @return int
     * @throws \Exception
     */
    public function mostPopularNumber(array $numbers = []) : int
    {
        if (count($numbers) < 1) {
            throw new \Exception('empry');
        }
        $counter = [];
        foreach ($numbers as $number) {
            if (!is_int($number) || $number < 0 ) {
                throw new \Exception('Wrong input');
            }

            if (!isset($counter[$number])) {
                $counter[$number] = 1;
            } else {
                ++ $counter[$number];
            }
        }

        arsort($counter);

        return array_key_first($counter);
    }

    /**
     * @Route("/demo", name="app_demo")
     * @throws \Exception
     */
    public function demo(): JsonResponse
    {
        $result = $this->mostPopularNumber([1, 2, 2, 2, 3, 4, 5, 5]);
//        $result = $this->isAlmostPalindrome('abcxx');
//
//        $avgDist = $this->avgDistance(1, 1, 2, 2, 3, 3);


        return new JsonResponse(['result' => $result]);
    }
}
