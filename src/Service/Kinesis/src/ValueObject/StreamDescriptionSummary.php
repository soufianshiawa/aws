<?php

namespace AsyncAws\Kinesis\ValueObject;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Kinesis\Enum\EncryptionType;
use AsyncAws\Kinesis\Enum\StreamStatus;

/**
 * Represents the output for DescribeStreamSummary.
 */
final class StreamDescriptionSummary
{
    /**
     * The name of the stream being described.
     *
     * @var string
     */
    private $streamName;

    /**
     * The Amazon Resource Name (ARN) for the stream being described.
     *
     * @var string
     */
    private $streamArn;

    /**
     * The current status of the stream being described. The stream status is one of the following states:.
     *
     * - `CREATING` - The stream is being created. Kinesis Data Streams immediately returns and sets `StreamStatus` to
     *   `CREATING`.
     * - `DELETING` - The stream is being deleted. The specified stream is in the `DELETING` state until Kinesis Data
     *   Streams completes the deletion.
     * - `ACTIVE` - The stream exists and is ready for read and write operations or deletion. You should perform read and
     *   write operations only on an `ACTIVE` stream.
     * - `UPDATING` - Shards in the stream are being merged or split. Read and write operations continue to work while the
     *   stream is in the `UPDATING` state.
     *
     * @var StreamStatus::*
     */
    private $streamStatus;

    /**
     * Specifies the capacity mode to which you want to set your data stream. Currently, in Kinesis Data Streams, you can
     * choose between an **on-demand** ycapacity mode and a **provisioned** capacity mode for your data streams.
     *
     * @var StreamModeDetails|null
     */
    private $streamModeDetails;

    /**
     * The current retention period, in hours.
     *
     * @var int
     */
    private $retentionPeriodHours;

    /**
     * The approximate time that the stream was created.
     *
     * @var \DateTimeImmutable
     */
    private $streamCreationTimestamp;

    /**
     * Represents the current enhanced monitoring settings of the stream.
     *
     * @var EnhancedMetrics[]
     */
    private $enhancedMonitoring;

    /**
     * The encryption type used. This value is one of the following:.
     *
     * - `KMS`
     * - `NONE`
     *
     * @var EncryptionType::*|null
     */
    private $encryptionType;

    /**
     * The GUID for the customer-managed Amazon Web Services KMS key to use for encryption. This value can be a globally
     * unique identifier, a fully specified ARN to either an alias or a key, or an alias name prefixed by "alias/".You can
     * also use a master key owned by Kinesis Data Streams by specifying the alias `aws/kinesis`.
     *
     * - Key ARN example: `arn:aws:kms:us-east-1:123456789012:key/12345678-1234-1234-1234-123456789012`
     * - Alias ARN example: ` arn:aws:kms:us-east-1:123456789012:alias/MyAliasName`
     * - Globally unique key ID example: `12345678-1234-1234-1234-123456789012`
     * - Alias name example: `alias/MyAliasName`
     * - Master key owned by Kinesis Data Streams: `alias/aws/kinesis`
     *
     * @var string|null
     */
    private $keyId;

    /**
     * The number of open shards in the stream.
     *
     * @var int
     */
    private $openShardCount;

    /**
     * The number of enhanced fan-out consumers registered with the stream.
     *
     * @var int|null
     */
    private $consumerCount;

    /**
     * @param array{
     *   StreamName: string,
     *   StreamARN: string,
     *   StreamStatus: StreamStatus::*,
     *   StreamModeDetails?: null|StreamModeDetails|array,
     *   RetentionPeriodHours: int,
     *   StreamCreationTimestamp: \DateTimeImmutable,
     *   EnhancedMonitoring: array<EnhancedMetrics|array>,
     *   EncryptionType?: null|EncryptionType::*,
     *   KeyId?: null|string,
     *   OpenShardCount: int,
     *   ConsumerCount?: null|int,
     * } $input
     */
    public function __construct(array $input)
    {
        $this->streamName = $input['StreamName'] ?? $this->throwException(new InvalidArgument('Missing required field "StreamName".'));
        $this->streamArn = $input['StreamARN'] ?? $this->throwException(new InvalidArgument('Missing required field "StreamARN".'));
        $this->streamStatus = $input['StreamStatus'] ?? $this->throwException(new InvalidArgument('Missing required field "StreamStatus".'));
        $this->streamModeDetails = isset($input['StreamModeDetails']) ? StreamModeDetails::create($input['StreamModeDetails']) : null;
        $this->retentionPeriodHours = $input['RetentionPeriodHours'] ?? $this->throwException(new InvalidArgument('Missing required field "RetentionPeriodHours".'));
        $this->streamCreationTimestamp = $input['StreamCreationTimestamp'] ?? $this->throwException(new InvalidArgument('Missing required field "StreamCreationTimestamp".'));
        $this->enhancedMonitoring = isset($input['EnhancedMonitoring']) ? array_map([EnhancedMetrics::class, 'create'], $input['EnhancedMonitoring']) : $this->throwException(new InvalidArgument('Missing required field "EnhancedMonitoring".'));
        $this->encryptionType = $input['EncryptionType'] ?? null;
        $this->keyId = $input['KeyId'] ?? null;
        $this->openShardCount = $input['OpenShardCount'] ?? $this->throwException(new InvalidArgument('Missing required field "OpenShardCount".'));
        $this->consumerCount = $input['ConsumerCount'] ?? null;
    }

    /**
     * @param array{
     *   StreamName: string,
     *   StreamARN: string,
     *   StreamStatus: StreamStatus::*,
     *   StreamModeDetails?: null|StreamModeDetails|array,
     *   RetentionPeriodHours: int,
     *   StreamCreationTimestamp: \DateTimeImmutable,
     *   EnhancedMonitoring: array<EnhancedMetrics|array>,
     *   EncryptionType?: null|EncryptionType::*,
     *   KeyId?: null|string,
     *   OpenShardCount: int,
     *   ConsumerCount?: null|int,
     * }|StreamDescriptionSummary $input
     */
    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getConsumerCount(): ?int
    {
        return $this->consumerCount;
    }

    /**
     * @return EncryptionType::*|null
     */
    public function getEncryptionType(): ?string
    {
        return $this->encryptionType;
    }

    /**
     * @return EnhancedMetrics[]
     */
    public function getEnhancedMonitoring(): array
    {
        return $this->enhancedMonitoring;
    }

    public function getKeyId(): ?string
    {
        return $this->keyId;
    }

    public function getOpenShardCount(): int
    {
        return $this->openShardCount;
    }

    public function getRetentionPeriodHours(): int
    {
        return $this->retentionPeriodHours;
    }

    public function getStreamArn(): string
    {
        return $this->streamArn;
    }

    public function getStreamCreationTimestamp(): \DateTimeImmutable
    {
        return $this->streamCreationTimestamp;
    }

    public function getStreamModeDetails(): ?StreamModeDetails
    {
        return $this->streamModeDetails;
    }

    public function getStreamName(): string
    {
        return $this->streamName;
    }

    /**
     * @return StreamStatus::*
     */
    public function getStreamStatus(): string
    {
        return $this->streamStatus;
    }

    /**
     * @return never
     */
    private function throwException(\Throwable $exception)
    {
        throw $exception;
    }
}
