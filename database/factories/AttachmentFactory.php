<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = [
            'image' => [
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'file_size' => $this->faker->numberBetween(100000, 5000000),
            ],
            'document' => [
                'mime_type' => 'application/pdf',
                'extension' => 'pdf',
                'file_size' => $this->faker->numberBetween(50000, 2000000),
            ],
            'text' => [
                'mime_type' => 'text/plain',
                'extension' => 'txt',
                'file_size' => $this->faker->numberBetween(1000, 50000),
            ],
        ];

        $fileType = $this->faker->randomElement(array_keys($fileTypes));
        $typeInfo = $fileTypes[$fileType];

        $fileName = Str::uuid() . '.' . $typeInfo['extension'];
        $originalName = $this->faker->words(2, true) . '.' . $typeInfo['extension'];

        return [
            'name' => $this->faker->words(3, true),
            'original_name' => $originalName,
            'file_path' => 'attachments/' . $fileName,
            'file_size' => $typeInfo['file_size'],
            'mime_type' => $typeInfo['mime_type'],
            'extension' => $typeInfo['extension'],
            'disk' => 'public',
            'description' => $this->faker->optional()->sentence(),
            'alt_text' => $this->faker->optional()->words(3, true),
            'user_id' => User::factory(),
            'attachable_type' => null,
            'attachable_id' => null,
            'is_public' => $this->faker->boolean(80), // 80% 概率为公开
            'download_count' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * 创建图片附件
     */
    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/webp']),
            'extension' => $this->faker->randomElement(['jpg', 'jpeg', 'png', 'gif', 'webp']),
            'file_size' => $this->faker->numberBetween(100000, 5000000),
        ]);
    }

    /**
     * 创建文档附件
     */
    public function document(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => $this->faker->randomElement([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]),
            'extension' => $this->faker->randomElement(['pdf', 'doc', 'docx', 'xls', 'xlsx']),
            'file_size' => $this->faker->numberBetween(50000, 2000000),
        ]);
    }

    /**
     * 创建公开附件
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    /**
     * 创建私有附件
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }
}
