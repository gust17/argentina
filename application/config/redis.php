<?php
$config['redis_default']['host'] = getenv('REDIS_HOST') ?? 'redis-11169.c261.us-east-1-4.ec2.cloud.redislabs.com';
$config['redis_default']['port'] = getenv('REDIS_PORT') ?? '11169';
$config['redis_default']['password'] = getenv('REDIS_PASS') ?? 'xxljBeljTPC3SRQTf8WwMt5HVb6ALvbF';