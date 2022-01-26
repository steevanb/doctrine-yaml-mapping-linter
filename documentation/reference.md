```yaml
FullyClassifiedClassName:
    # string, mandatory, available values: entity, mappedSuperclass, embeddable
    type: string
    # fqcn, optional, available only when type = entity
    repositoryClass: class-string
    # bool, optional, default value: false, available only when type = entity
    readOnly: bool
```
