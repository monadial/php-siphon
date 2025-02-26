<?php

declare(strict_types=1);

namespace Monadial\Siphon;

enum PrecisionScale
{
    // 🔬 Scientific Precision (High Accuracy)
    case SCIENTIFIC_HIGH; // Nanotechnology, quantum physics (e.g., 10⁻⁹)
    case SCIENTIFIC_MEDIUM; // Micro measurements, laser precision (e.g., 10⁻⁶)
    case SCIENTIFIC_LOW; // General lab work, small-scale engineering

    // 📏 General-Purpose Precision (Daily Use, Measurement Tools)
    case GENERAL_HIGH; // Millimeter precision (e.g., 1.234 m)
    case GENERAL_MEDIUM; // Centimeter precision (e.g., 1.23 m)
    case GENERAL_LOW; // Practical measurements (e.g., 1.2 m)

    // ⚙️ Engineering / Industrial Precision
    case ENGINEERING_FINE; // Micrometer-level accuracy
    case ENGINEERING_STANDARD; // Precision in machinery, aviation, structural work
    case ENGINEERING_COARSE; // Everyday construction, civil engineering

    // 🚀 Astronomical / Large Scale Precision
    case ASTRONOMICAL_PRECISION; // Used in space sciences

    case UNSCALED; // No scale defined result is in integer form

    public function scale(): int
    {
        return match ($this) {
            self::SCIENTIFIC_HIGH => 9,
            self::SCIENTIFIC_MEDIUM, self::ENGINEERING_FINE => 6,
            self::SCIENTIFIC_LOW, self::GENERAL_HIGH => 3,
            self::GENERAL_MEDIUM, self::ENGINEERING_COARSE => 2,
            self::GENERAL_LOW => 1,
            self::ENGINEERING_STANDARD => 4,
            self::ASTRONOMICAL_PRECISION => 5,
            self::UNSCALED => 0,
        };
    }
}
