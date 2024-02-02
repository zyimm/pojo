# PHP数组转为类Java POJO对象处理提高程序安全性

安装

```shell
composer  require zyimm/php-pojo
```

## 使用示例

```php
class DemoDto extends \Zyimm\Pojo\Pojo
{
    private $id；
    
    private $name;
    
    /**
     * @return mixed
     */
     public  function getId()
     {
        return $this->id;
     }
     
      public  function setId(int $id)
     {
        $this->id = $id;
     }
    
    /**
     * @return string
     */
     public  function getName():string
     {
        return $this->name;
     }
     
     public  function setName(string $name)
     {
         $this->name = $name;
     }

}


$dto = new DemoBto([
    'id' => 1
    'name' => 'name'
])

echo $dto['id']; // 1  or  $dto->getId();



```

