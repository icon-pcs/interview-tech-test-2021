<?php declare(strict_types=1);

namespace IconLanguageServices\ApiClient\Test\AccessToken;

use IconLanguageServices\ApiClient\AccessToken\AccessToken;
use IconLanguageServices\ApiClient\Test\TestCase;

/**
 * @coversDefaultClass \IconLanguageServices\ApiClient\AccessToken\AccessToken
 */
class AccessTokenTest extends TestCase
{
    /**
     * @test
     * @covers ::hasExpired
     */
    public function it_returns_true_if_the_number_of_seconds_specified_in_expires_in_has_passed(): void
    {
        $token = new AccessToken(yesterday(), "abc");

        self::assertTrue($token->hasExpired(), "Access token has not expired");
    }

    /**
     * @test
     * @covers ::hasExpired
     */
    public function it_returns_false_if_the_number_of_seconds_specified_in_expires_in_has_not_passed(): void
    {
        $token = new AccessToken(tomorrow(), "abc");

        self::assertFalse($token->hasExpired(), "Access token has  expired");
    }

    /**
     * @test
     * @covers ::expiresInNext
     */
    public function it_returns_true_if_token_expires_before_given_number_of_seconds_have_passed(): void
    {
        $token = new AccessToken(inFiveSeconds(), "abc");
        $tenSeconds = 10;

        self::assertTrue($token->expiresInNext($tenSeconds), "Token does not expire in next {$tenSeconds} seconds");
    }

    /**
     * @test
     * @covers ::expiresInNext
     */
    public function it_returns_false_if_token_expires_after_given_number_of_seconds_have_passed(): void
    {
        $token = new AccessToken(inFiveSeconds(), "abc");
        $twoSeconds = 2;

        self::assertFalse($token->expiresInNext($twoSeconds), "Token expires in next {$twoSeconds} seconds");
    }
}
