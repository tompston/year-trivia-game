<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TriviaController extends Controller
{
    /**
     * 
     * 1. Fetch a random year trivia using 
     *    this endpoint -> http://numbersapi.com/random/year
     * 
     * 2. Clean the response (get the year 
     *    and corresponding answer for that year)
     * 
     * 3. Create an array of strings that hold 4 total trivia 
     *    answers, where the first string in the array is the 
     *    correct answer.
     *      - Reuse the function that fetches 
     *        the trivia endpoint, by providing an int as a param,
     *        to indicate which year should be excluded. 
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $correct_answer = fetchTriviaEndpoint();
        $correct_year = firstWordInString($correct_answer);

        $data = array(
            stringAfterPhrase($correct_answer),
            fetchTriviaForRandomYearExcluding($correct_year),
            fetchTriviaForRandomYearExcluding($correct_year),
            fetchTriviaForRandomYearExcluding($correct_year),
        );

        return response([
            "year"      => $correct_year,
            "data"      => $data,
        ], 200);
    }
}





/**
 * This should me moved to another place, ideally
 */

/** Fetch trivia endpoint that gets a random fact about a random year */
function fetchTriviaEndpoint(int $year = 0)
{
    if ($year != 0) {
        return file_get_contents("http://numbersapi.com/{$year}/year");
    }
    return file_get_contents("http://numbersapi.com/random/year");
}

/**
 * Reference - https://www.geeksforgeeks.org/how-to-remove-portion-of-a-string-after-a-certain-character-in-php/
 * 
 * Return the part of the input string that starts after
 * the phrase (excluding the phrase). */
function stringAfterPhrase(string $answer, string $phrase = "year that "): string
{
    // return a string that starts with the phrase
    $answer = strstr($answer, $phrase, false);
    // then remove that phrase
    $answer = str_replace($phrase, '', $answer);
    return $answer;
}

/** Return the first word from the string
 *  NOTE: Need to write a check, if the passed in string is not empty */
function firstWordInString(string $str): string
{
    return strtok($str, " ");
}

/** Return a random int
 *  Reference - https://stackoverflow.com/questions/17109465/php-rand-exclude-certain-numbers */
function getRandomNumberThatExludes(int $min, int $max, array $excluding): int
{
    do {
        $n = mt_rand($min, $max);
    } while (in_array($n, $excluding));

    return $n;
}

/**
 * Return a cleaned up string, that is returned from the API
 */
function fetchTriviaForRandomYearExcluding(string $exclude)
{
    $random_year = getRandomNumberThatExludes(50, 2010, array($exclude));
    $random_year_trivia = fetchTriviaEndpoint($random_year);
    $random_year_trivia_answer = stringAfterPhrase($random_year_trivia);
    return $random_year_trivia_answer;
}
