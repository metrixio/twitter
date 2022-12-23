# Twitter metrics collector

Welcome to the Twitter metrics collector!

This package allows you to easily collect various metrics from Twitter, such as tweets, retweets, likes, followers,
and more. With this tool, you can track the performance of your own Twitter account, or gather data for research or
analysis purposes.

It is designed to work seamlessly with Prometheus and Grafana. It will collect data from Twitter and send it to
Prometheus for storage, and then use Grafana to visualize the data in beautiful and informative dashboards. Grafana
offers a variety of options for filtering and specifying the data you want to collect, so you can customize your metrics
collection to fit your needs.

It uses GRPC service to manage Twitter accounts. GRPC is a high-performance.

We hope you find this package useful!

## Usage

To use the package, you will need to have a Twitter developer account and create a Twitter API key. Once you have
obtained your API key, you can use the package's functions to authenticate and start collecting data.

```dotenv
# Twitter
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=

# Twitter account ids to follow (comma separated)
TWITTER_ACCOUNTS=
```

### Docker

```yaml
version: "3.7"

services:
  twitter-metrics:
    image: ghcr.io/metrixio/twitter:latest
    environment:
      TWITTER_CONSUMER_KEY:...
      TWITTER_CONSUMER_SECRET:...
      TWITTER_ACCESS_TOKEN:...
      TWITTER_ACCESS_TOKEN_SECRET:...
      TWITTER_ACCOUNTS:...
    restart: on-failure

  prometheus:
    image: prom/prometheus
    volumes:
      - ./runtime/prometheus:/prometheus
    restart: always

  grafana:
    image: grafana/grafana
    depends_on:
      - prometheus
    ports:
      - 3000:3000
    volumes:
      - ./runtime/grafana:/var/lib/grafana
    restart: always
```
