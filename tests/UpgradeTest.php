<?php

use PHPUnit\Framework\TestCase;
use Screen\Testing\RandomEnum;
use Screen\Exceptions\FileNotFoundException;
use Screen\Injection\LocalPath;

class UpgradeTest extends TestCase
{
    private const PROJECT_PATH = '/home/martin/PhpstormProjects/screen';
    private readonly string $test;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->test = 'test';
    }

    /**
     * @throws FileNotFoundException
     * @covers \Screen\Injection\LocalPath
     */
    public function testImageExists(): void
    {
        $localPath = new LocalPath(self::PROJECT_PATH . '/demo/assets/image_one.png');
        $this->assertNotEmpty($localPath);
    }


    /**
     * @covers \Screen\Injection\LocalPath
     */
    public function testImageDoesNotExist(): void
    {
        $this->expectException(FileNotFoundException::class);
        new LocalPath('/demo/assets/image_two.png');
    }

    /**
     * @covers \Screen\Injection\Url
     */
    public function testUrlValid(): void
    {
        $this->assertNotEmpty(new \Screen\Injection\Url('fb.com'));
    }

    /**
     * @covers
     */
    public function testCaptureCreation(): void
    {
        $capture = new \Screen\Capture('www.fb.com');
        $this->assertNotEmpty($capture);
    }

    /**
     * @covers \Screen\Capture
     * @uses \Screen\Location\Jobs
     */
    public function testCaptureLocation(): void
    {
        $capture = new \Screen\Capture('www.fb.com');
        $location = self::PROJECT_PATH . '/demo/assets/';
        $capture->jobs->setLocation($location);
        $this->assertSame($capture->jobs->getLocation(), $location);
    }

    /**
     * @covers \Screen\Capture
     */
    public function testCaptureSave(): void
    {
        $capture = new \Screen\Capture('www.fb.com');
        $capture->setWidth(1200);
        $capture->setHeight(800);
        $capture->setTop(100);
        $capture->setLeft(100);
        $capture->setClipWidth(1200);
        $capture->setClipHeight(800);
        $this->assertIsBool($capture->save('jozko.jpg'));
    }

    /**
     * @covers \Screen\Capture
     */
    public function testCaptureImageType(): void
    {
        $capture = new \Screen\Capture('www.fb.com');
        $this->assertInstanceOf(\Screen\Image\Types\Type::class, $capture->getImageType());
    }

    /**
     * @covers \Screen\Testing\RandomEnum
     */
    public function testPhpEnum(): void
    {
        $color = RandomEnum::Black;
        $this->assertSame('Black', $color->name);
        $this->assertSame('black', $color->value);
    }

    public function testArrayDump(): void
    {
        $array1 = ["a" => 1];
        $array2 = ["b" => 2];
        $array = ["a" => 0, ...$array1, ...$array2];

        $finalArray = ["a" => 1, "b" => 2];

        $this->assertSame($array, $finalArray);
    }

    public function testReadOnlyProperty(): void
    {
        $this->expectError();
        $this->test = 'haha';
    }

    public function testArrayIsList(): void
    {
        $list = ["a", "b", "c"];

        $this->assertTrue(array_is_list($list));

        $notAList = [1 => "a", 2 => "b", 3 => "c"];

        $this->assertFalse(array_is_list($notAList));
    }

    public function testUnionType(): void
    {
        self::assertIsString($this->unionType('a'));
        self::assertIsInt($this->unionType(4));
    }

    private function unionType(string|int $a): string|int
    {
        return $a;
    }

    public function testMatch(): void
    {
        $hello = match (0) {
            0 => "hello",
            '1', '2', '3' => "world",
        };
        $this->assertSame('hello', $hello);

        $world = match ('2') {
            0 => "hello",
            '1', '2', '3' => "world",
        };

        $this->assertSame('world', $world);
    }
}