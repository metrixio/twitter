# Twitter metrics collector

![twitter](https://user-images.githubusercontent.com/773481/209433204-d3a5efb4-80f8-495b-bfbf-f4806f4d094b.png)

This tool lets you easily gather data about tweets, retweets, likes, followers, and more from Twitter. You can use it to track the performance of your own account or gather data for research or analysis. It works with Prometheus and Grafana to collect data from Twitter, store it in Prometheus, and create visualizations with Grafana. You can use Grafana to customize the data you collect and create dashboards that fit your needs.

We hope you find it helpful!

## Usage

To get started with this package, you'll need to have a Twitter developer account and create [Twitter API credentials](https://developer.twitter.com/en/docs/basics/authentication/guides/access-tokens.html). Once you have those, you can begin collecting metrics data from Twitter. 

It's a simple process that can help you track the performance of your own account or gather data for research or analysis purposes.

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
