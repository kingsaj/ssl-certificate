<?php

namespace LiquidWeb\SslCertificate\Test;

use PHPUnit_Framework_TestCase;
use LiquidWeb\SslCertificate\SslCertificate;

class SslCertificateDownloadsTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_create_an_instance_for_the_given_host()
    {
        $downloadedCertificate = SslCertificate::createForHostName('spatie.be');

        $this->assertSame('spatie.be', $downloadedCertificate->getDomain());
    }

    /** @test */
    public function it_can_verify_host_domains()
    {
        $downloadedCertificate = SslCertificate::createForHostName('google.com');

        $this->assertSame('*.google.com', $downloadedCertificate->getDomain());
        $this->assertSame(true, $downloadedCertificate->appliesToUrl('*.google.com'));
    }

    /** @test */
    public function it_can_verify_nasty_ssls()
    {
        $downloadedCertificate = SslCertificate::createForHostName('edellroot.badssl.com');

        $this->assertSame(false, $downloadedCertificate->isSelfSigned());
        $this->assertSame(false, $downloadedCertificate->appliesToUrl('badssl.com'));
        $this->assertSame('edellroot.badssl.com', $downloadedCertificate->getDomain());
    }
}
