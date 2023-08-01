<?php

use Aws\Exception\AwsException;
use Aws\S3\S3Client;

function UploadS3($key, $file_path, $bucket)
{

    try {
        $s3Client = new S3Client([
            'credentials' => array(
                'key'    => $_SERVER['AWS_KEY'] ?? 'AKIAWFHBCSMUSZ5W3BUR',
                'secret' => $_SERVER['AWS_SECRET'] ?? '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',
            ),
            'region' => 'us-east-1',
            'version' => '2006-03-01'
        ]);

        $result = $s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $file_path,
        ]);

        return $result;
    } catch (AwsException $e) {

        return $e->getMessage();
    }
}
