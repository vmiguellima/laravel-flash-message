<?php

namespace Ubient\FlashMessage\Tests\Feature\AssertHasFlashMessage;

use PHPUnit\Framework\ExpectationFailedException;
use Ubient\FlashMessage\Tests\TestCase;

class AssertHasWarningMessageTest extends TestCase
{
    /** @test */
    public function it_should_assert_the_flash_message_was_set(): void
    {
        app('router')->get('/', function () {
            return redirect('/')->withWarningMessage('I have an unfortunate personality.');
        });

        tap($this->get('/'), function ($response) {
            $response->assertHasWarningMessage();
        });
    }

    /** @test */
    public function it_should_assert_the_flash_message_was_set_and_has_the_expected_message(): void
    {
        $message = 'Vision is the true creative rhythm.';
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withWarningMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $response->assertHasWarningMessage($message);
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_no_flash_message_set(): void
    {
        app('router')->get('/', function () {
            return redirect('/');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasWarningMessage();
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_no_flash_message_set_for_the_expected_message(): void
    {
        app('router')->get('/', function () {
            return redirect('/');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasWarningMessage('In the future, everyone will be famous for 15 minutes.');
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_a_different_message(): void
    {
        app('router')->get('/', function () {
            return redirect('/')->withWarningMessage('Nine-tenths of wisdom is being wise in time.');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasWarningMessage('A wide screen just makes a bad film twice as bad.');
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_the_expected_message_but_a_different_flash_message_type(): void
    {
        $message = "There's a difference between a philosophy and a bumper sticker.";
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withWarningMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasErrorMessage($message);
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_a_different_flash_message_type(): void
    {
        app('router')->get('/', function () {
            return redirect('/')->withWarningMessage('The less we deserve good fortune, the more we hope for it.');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasErrorMessage();
        });
    }
}
