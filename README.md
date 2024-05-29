## Example API

This is sample API setup that demonstrates the following features:

- Advanced resource queries
- Custom paginated responses
- Eloquent models with various database connections
- API versioning


## Advanced Resource Queries

API resources support structured queries to allow advanced data retrieval. For example:

GET http://127.0.0.1:8000/api/v2/ag_platformGroups

JSON Payload:

```json
{
    "filter": {
        "where": {
            "controller_id": {
                "gt": 107733
            }
        },
        "fields": [
            "id",
            "controller_id"
        ],
        "order": "controller_id desc",
        "perPage": 5,
        "include": {
            "relation": "platforms",
            "scope": {
                "limit": 1,
                "order": "id asc",
                "fields": [
                    "id",
                    "platformType_id"
                ]
            }
        }
    }
}
```

In the above example, the "ag_platformGroups" resource is queried, retrieving the first 5 records where the "controller_id" is greater than 107733. The desired fields are specified, and related models are included.

Example response:

```json
{
    "data": [
        {
            "id": 2279,
            "controller_id": 107737,
            "platforms": [
                {
                    "id": 9730,
                    "platformType_id": 3
                }
            ]
        },
        {
            "id": 2278,
            "controller_id": 107736,
            "platforms": [
                {
                    "id": 9726,
                    "platformType_id": 3
                }
            ]
        },
        {
            "id": 2277,
            "controller_id": 107735,
            "platforms": [
                {
                    "id": 9722,
                    "platformType_id": 3
                }
            ]
        },
        {
            "id": 2276,
            "controller_id": 107734,
            "platforms": [
                {
                    "id": 9718,
                    "platformType_id": 3
                }
            ]
        }
    ],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://127.0.0.1:8000/api/v2/ag_platformGroups",
        "per_page": 5,
        "to": 4,
        "total": 4
    }
}
```

Individual resources support structured queries as well. For example:

GET http://127.0.0.1:8000/api/v2/ag_platformGroups/2279

JSON Payload:
```json
{
    "filter": {
        "fields": ["id", "controller_id"],
        "include": {
            "relation": "platforms",
            "scope": {
                "limit": 1,
                "order": "id asc",
                "fields": ["id", "platformType_id"]
            }
        }
    }
}
```

Example response:
```json
{
    "data": {
        "id": 2279,
        "controller_id": 107737,
        "platforms": [
            {
                "id": 9730,
                "platformType_id": 3
            }
        ]
    }
}
```
