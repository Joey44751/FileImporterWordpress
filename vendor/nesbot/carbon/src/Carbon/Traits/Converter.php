<?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Carbon\Traits;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Carbon\Exceptions\UnitException;
use Closure;
use DateTime;
use DateTimeImmutable;
use ReturnTypeWillChange;

/**
 * Trait Converter.
 *
 * Change date into different string formats and types and
 * handle the string cast.
 *
 * Depends on the following methods:
 *
 * @method static copy()
 */
trait Converter
{
    use ToStringFormat;

    /**
     * Returns the formatted date string on success or FALSE on failure.
     *
     * @see https://php.net/manual/en/datetime.format.php
     *
     * @param string $format
     *
     * @return string
     */
    #[ReturnTypeWillChange]
    public function format($format)
    {
        $function = $this->localFormatFunction ?: static::$formatFunction;

        if (!$function) {
            return $this->rawFormat($format);
        }

        if (\is_string($function) && method_exists($this, $function)) {
            $function = [$this, $function];
        }

        return $function(...\func_get_args());
    }

    /**
     * @see https://php.net/manual/en/datetime.format.php
     *
     * @param string $format
     *
     * @return string
     */
    public function rawFormat($format)
    {
        return parent::format($format);
    }

    /**
     * Format the instance as a string using the set format
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now(); // Carbon instances can be cast to string
     * ```
     *
     */
    public function __toString()
    {
        $format = $this->localToStringFormat ?? static::$toStringFormat;

        return $format instanceof Closure
            ? $format($this)
            : $this->rawFormat($format ?: (
            \defined('static::DEFAULT_TO_STRING_FORMAT')
                ? static::DEFAULT_TO_STRING_FORMAT
                : CarbonInterface::DEFAULT_TO_STRING_FORMAT
            ));
    }

    /**
     * Format the instance as date
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toDateString();
     * ```
     *
     */
    public function toDateString()
    {
        return $this->rawFormat('Y-m-d');
    }

    /**
     * Format the instance as a readable date
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toFormattedDateString();
     * ```
     *
     */
    public function toFormattedDateString()
    {
        return $this->rawFormat('M j, Y');
    }

    /**
     * Format the instance with the day, and a readable date
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toFormattedDayDateString();
     * ```
     *
     */
    public function toFormattedDayDateString(): string
    {
        return $this->rawFormat('D, M j, Y');
    }

    /**
     * Format the instance as time
     *
     * @param string $unitPrecision
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toTimeString();
     * ```
     *
     */
    public function toTimeString($unitPrecision = 'second')
    {
        return $this->rawFormat(static::getTimeFormatByPrecision($unitPrecision));
    }

    /**
     * Format the instance as date and time
     *
     * @param string $unitPrecision
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toDateTimeString();
     * ```
     *
     */
    public function toDateTimeString($unitPrecision = 'second')
    {
        return $this->rawFormat('Y-m-d ' . static::getTimeFormatByPrecision($unitPrecision));
    }

    /**
     * Return a format from H:i to H:i:s.u according to given unit precision.
     *
     * @param string $unitPrecision "minute", "second", "millisecond" or "microsecond"
     *
     * @return string
     */
    public static function getTimeFormatByPrecision($unitPrecision)
    {
        switch (static::singularUnit($unitPrecision)) {
            case 'minute':
                return 'H:i';
            case 'second':
                return 'H:i:s';
            case 'm':
            case 'millisecond':
                return 'H:i:s.v';
            case 'µ':
            case 'microsecond':
                return 'H:i:s.u';
        }

        throw new UnitException('Precision unit expected among: minute, second, millisecond and microsecond.');
    }

    /**
     * Format the instance as date and time T-separated with no timezone
     *
     * @param string $unitPrecision
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toDateTimeLocalString();
     * echo "\n";
     * echo Carbon::now()->toDateTimeLocalString('minute'); // You can specify precision among: minute, second, millisecond and microsecond
     * ```
     *
     */
    public function toDateTimeLocalString($unitPrecision = 'second')
    {
        return $this->rawFormat('Y-m-d\T' . static::getTimeFormatByPrecision($unitPrecision));
    }

    /**
     * Format the instance with day, date and time
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toDayDateTimeString();
     * ```
     *
     */
    public function toDayDateTimeString()
    {
        return $this->rawFormat('D, M j, Y g:i A');
    }

    /**
     * Format the instance as ATOM
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toAtomString();
     * ```
     *
     */
    public function toAtomString()
    {
        return $this->rawFormat(DateTime::ATOM);
    }

    /**
     * Format the instance as COOKIE
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toCookieString();
     * ```
     *
     */
    public function toCookieString()
    {
        return $this->rawFormat(DateTime::COOKIE);
    }

    /**
     * Format the instance as ISO8601
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toIso8601String();
     * ```
     *
     */
    public function toIso8601String()
    {
        return $this->toAtomString();
    }

    /**
     * Format the instance as RFC822
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc822String();
     * ```
     *
     */
    public function toRfc822String()
    {
        return $this->rawFormat(DateTime::RFC822);
    }

    /**
     * Convert the instance to UTC and return as Zulu ISO8601
     *
     * @param string $unitPrecision
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toIso8601ZuluString();
     * ```
     *
     */
    public function toIso8601ZuluString($unitPrecision = 'second')
    {
        return $this->avoidMutation()
            ->utc()
            ->rawFormat('Y-m-d\T' . static::getTimeFormatByPrecision($unitPrecision) . '\Z');
    }

    /**
     * Format the instance as RFC850
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc850String();
     * ```
     *
     */
    public function toRfc850String()
    {
        return $this->rawFormat(DateTime::RFC850);
    }

    /**
     * Format the instance as RFC1036
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc1036String();
     * ```
     *
     */
    public function toRfc1036String()
    {
        return $this->rawFormat(DateTime::RFC1036);
    }

    /**
     * Format the instance as RFC1123
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc1123String();
     * ```
     *
     */
    public function toRfc1123String()
    {
        return $this->rawFormat(DateTime::RFC1123);
    }

    /**
     * Format the instance as RFC2822
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc2822String();
     * ```
     *
     */
    public function toRfc2822String()
    {
        return $this->rawFormat(DateTime::RFC2822);
    }

    /**
     * Format the instance as RFC3339
     *
     * @param bool $extended
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc3339String() . "\n";
     * echo Carbon::now()->toRfc3339String(true) . "\n";
     * ```
     *
     */
    public function toRfc3339String($extended = false)
    {
        $format = DateTime::RFC3339;
        if ($extended) {
            $format = DateTime::RFC3339_EXTENDED;
        }

        return $this->rawFormat($format);
    }

    /**
     * Format the instance as RSS
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRssString();
     * ```
     *
     */
    public function toRssString()
    {
        return $this->rawFormat(DateTime::RSS);
    }

    /**
     * Format the instance as W3C
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toW3cString();
     * ```
     *
     */
    public function toW3cString()
    {
        return $this->rawFormat(DateTime::W3C);
    }

    /**
     * Format the instance as RFC7231
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toRfc7231String();
     * ```
     *
     */
    public function toRfc7231String()
    {
        return $this->avoidMutation()
            ->setTimezone('GMT')
            ->rawFormat(\defined('static::RFC7231_FORMAT') ? static::RFC7231_FORMAT : CarbonInterface::RFC7231_FORMAT);
    }

    /**
     * Get default array representation.
     *
     * @return array
     * @example
     * ```
     * var_dump(Carbon::now()->toArray());
     * ```
     *
     */
    public function toArray()
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'dayOfWeek' => $this->dayOfWeek,
            'dayOfYear' => $this->dayOfYear,
            'hour' => $this->hour,
            'minute' => $this->minute,
            'second' => $this->second,
            'micro' => $this->micro,
            'timestamp' => $this->timestamp,
            'formatted' => $this->rawFormat(\defined('static::DEFAULT_TO_STRING_FORMAT') ? static::DEFAULT_TO_STRING_FORMAT : CarbonInterface::DEFAULT_TO_STRING_FORMAT),
            'timezone' => $this->timezone,
        ];
    }

    /**
     * Get default object representation.
     *
     * @return object
     * @example
     * ```
     * var_dump(Carbon::now()->toObject());
     * ```
     *
     */
    public function toObject()
    {
        return (object)$this->toArray();
    }

    /**
     * Returns english human readable complete date string.
     *
     * @return string
     * @example
     * ```
     * echo Carbon::now()->toString();
     * ```
     *
     */
    public function toString()
    {
        return $this->avoidMutation()->locale('en')->isoFormat('ddd MMM DD YYYY HH:mm:ss [GMT]ZZ');
    }

    /**
     * Return the ISO-8601 string (ex: 1977-04-22T06:00:00Z, if $keepOffset truthy, offset will be kept:
     * 1977-04-22T01:00:00-05:00).
     *
     * @param bool $keepOffset Pass true to keep the date offset. Else forced to UTC.
     *
     * @return null|string
     * @example
     * ```
     * echo Carbon::now('America/Toronto')->toISOString() . "\n";
     * echo Carbon::now('America/Toronto')->toISOString(true) . "\n";
     * ```
     *
     */
    public function toISOString($keepOffset = false)
    {
        if (!$this->isValid()) {
            return null;
        }

        $yearFormat = $this->year < 0 || $this->year > 9999 ? 'YYYYYY' : 'YYYY';
        $tzFormat = $keepOffset ? 'Z' : '[Z]';
        $date = $keepOffset ? $this : $this->avoidMutation()->utc();

        return $date->isoFormat("$yearFormat-MM-DD[T]HH:mm:ss.SSSSSS$tzFormat");
    }

    /**
     * Return the ISO-8601 string (ex: 1977-04-22T06:00:00Z) with UTC timezone.
     *
     * @return null|string
     * @example
     * ```
     * echo Carbon::now('America/Toronto')->toJSON();
     * ```
     *
     */
    public function toJSON()
    {
        return $this->toISOString();
    }

    /**
     * Return native DateTime PHP object matching the current instance.
     *
     * @return DateTime
     * @example
     * ```
     * var_dump(Carbon::now()->toDateTime());
     * ```
     *
     */
    public function toDateTime()
    {
        return new DateTime($this->rawFormat('Y-m-d H:i:s.u'), $this->getTimezone());
    }

    /**
     * Return native toDateTimeImmutable PHP object matching the current instance.
     *
     * @return DateTimeImmutable
     * @example
     * ```
     * var_dump(Carbon::now()->toDateTimeImmutable());
     * ```
     *
     */
    public function toDateTimeImmutable()
    {
        return new DateTimeImmutable($this->rawFormat('Y-m-d H:i:s.u'), $this->getTimezone());
    }

    /**
     * @alias toDateTime
     *
     * Return native DateTime PHP object matching the current instance.
     *
     * @return DateTime
     * @example
     * ```
     * var_dump(Carbon::now()->toDate());
     * ```
     *
     */
    public function toDate()
    {
        return $this->toDateTime();
    }

    /**
     * Create a iterable CarbonPeriod object from current date to a given end date (and optional interval).
     *
     * @param \DateTimeInterface|Carbon|CarbonImmutable|int|null $end period end date or recurrences count if int
     * @param int|\DateInterval|string|null $interval period default interval or number of the given $unit
     * @param string|null $unit if specified, $interval must be an integer
     *
     * @return CarbonPeriod
     */
    public function toPeriod($end = null, $interval = null, $unit = null)
    {
        if ($unit) {
            $interval = CarbonInterval::make("$interval " . static::pluralUnit($unit));
        }

        $period = (new CarbonPeriod())->setDateClass(static::class)->setStartDate($this);

        if ($interval) {
            $period->setDateInterval($interval);
        }

        if (\is_int($end) || (\is_string($end) && ctype_digit($end))) {
            $period->setRecurrences($end);
        } elseif ($end) {
            $period->setEndDate($end);
        }

        return $period;
    }

    /**
     * Create a iterable CarbonPeriod object from current date to a given end date (and optional interval).
     *
     * @param \DateTimeInterface|Carbon|CarbonImmutable|null $end period end date
     * @param int|\DateInterval|string|null $interval period default interval or number of the given $unit
     * @param string|null $unit if specified, $interval must be an integer
     *
     * @return CarbonPeriod
     */
    public function range($end = null, $interval = null, $unit = null)
    {
        return $this->toPeriod($end, $interval, $unit);
    }
}