# Clear index
curl -X DELETE http://localhost:9200/product_index \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json'

# Create index
curl -X PUT http://localhost:9200/product_index/ \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -d '{
  "settings": {
    "number_of_shards": 1,
    "analysis": {
      "filter": {
        "english_stop": {
          "type":       "stop",
          "stopwords":  "_english_"
        },
        "english_keywords": {
          "type":       "keyword_marker",
          "keywords":   ["example"]
        },
        "english_stemmer": {
          "type":       "stemmer",
          "language":   "english"
        },
        "english_possessive_stemmer": {
          "type":       "stemmer",
          "language":   "possessive_english"
        }
      },
      "analyzer": {
        "rebuilt_english": {
          "tokenizer":  "standard",
          "filter": [
            "english_possessive_stemmer",
            "lowercase",
            "english_stop",
            "english_keywords",
            "english_stemmer"
          ]
        }
      }
    }
  },
  "mappings": {
    "properties": {
      "description": {
        "type": "text",
        "fields": {
          "english": {
            "type":     "text",
            "analyzer": "english"
          },
          "suggest": {
            "type": "completion"
          }
        }
      }
    }
  }
}'

# Bulk load data
curl -s -X PUT "localhost:9200/product_index/_bulk?pretty" \
  -H 'Content-Type: application/json' \
  --data-binary "@elasticdata.json" \
   > /dev/null

# Make search
curl -X POST \
  http://localhost:9200/product_index/_search \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -d '{
  "suggest" : {
    "description_suggest" : {
      "prefix": "Alice",
      "completion": {
        "field": "description.suggest",
        "fuzzy": {
          "fuzziness": 1
        }
      }
    }
  },
  "_source": ["suggest"]
}'

curl -X POST \
  http://localhost:9200/product_index/_search \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -d '{
        "query" : {
          "match" : {
            "description.english": {
              "query": "Alice"
            }
          }
        }
      }'