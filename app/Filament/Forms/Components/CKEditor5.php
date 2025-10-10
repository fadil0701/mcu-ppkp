<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class CKEditor5 extends Field
{
    protected string $view = 'filament.forms.components.ckeditor5';

    protected int $height = 400;
    protected string $buildType = 'collaborative-document';
    protected array $config = [];
    protected bool $enableVariables = false;
    protected bool $enableImages = false;
    protected bool $enableTables = false;
    protected bool $showPreview = false;

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function height(int $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function buildType(string $buildType): static
    {
        $this->buildType = $buildType;
        return $this;
    }

    public function config(array $config): static
    {
        $this->config = $config;
        return $this;
    }

    public function enableVariables(bool $enable = true): static
    {
        $this->enableVariables = $enable;
        return $this;
    }

    public function enableImages(bool $enable = true): static
    {
        $this->enableImages = $enable;
        return $this;
    }

    public function enableTables(bool $enable = true): static
    {
        $this->enableTables = $enable;
        return $this;
    }

    public function showPreview(bool $show = true): static
    {
        $this->showPreview = $show;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getBuildType(): string
    {
        return $this->buildType;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getEnableVariables(): bool
    {
        return $this->enableVariables;
    }

    public function getEnableImages(): bool
    {
        return $this->enableImages;
    }

    public function getEnableTables(): bool
    {
        return $this->enableTables;
    }

    public function getShowPreview(): bool
    {
        return $this->showPreview;
    }
}
