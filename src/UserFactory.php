<?php

namespace App;

use Carbon\CarbonImmutable;
use ReflectionClass;
use ReflectionParameter;

/**
 * User Factory
 */
class UserFactory
{

    /**
     * 指定されたパラメータでUserクラスを生成する
     *
     * @param  array $params パラメータ
     * @return User Userクラス
     */
    public function create(array $params): User
    {
        return $this->arrayToClass($params, User::class);
    }


    /**
     * 配列情報からクラスを生成する
     *
     * @param  array  $params     生成元の情報配列([key
     *                            => value])
     * @param  string $class_name 生成するクラス名
     * @return null|object 生成したクラス
     */
    private function arrayToClass(
        array $params,
        string $class_name
    ): ?object {
        $reflector = new ReflectionClass($class_name);
        $ref_constructor = $reflector->getConstructor();
        $ref_constructor_params = $ref_constructor->getParameters();

        // コンストラクタパラメータ配列生成
        $target_params = collect($ref_constructor_params)->map(
            function ($item) use ($params) {
                return $this->getTypedValue($params, $item);
            }
        )->toArray();

        // Model生成
        return $reflector->newInstanceArgs($target_params);
    }

    /**
     * 引数情報をもとに型変換した値を返却する
     *
     * @param  array               $params パラメータ配列
     * @param  ReflectionParameter $item   引数情報
     * @return mixed 値
     */
    private function getTypedValue(array $params, ReflectionParameter $item): mixed
    {
        // パラメータ名
        $name = $item->getName();

        // パラメータの型
        $type = str_replace('?', '', $item->getType());

        // パラメータの値
        //  - 指定されていない場合はnullとする
        $value = $params[$name] ?? null;

        // 型変換
        //  - int
        //  - string
        //  - array
        //  - 日付／時刻
        //  - Enum
        $typed_value = match($type) {
            'int'                     => $value,
            'string'                  => $value,
            'array'                   => $value,
            'Carbon\\CarbonImmutable' => CarbonImmutable::parse($value),
            default                   => $type::from($value),
        };

        return $typed_value;
    }
}
