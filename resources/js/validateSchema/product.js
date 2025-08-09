import * as yup from "yup";

export const productSchema = yup.object().shape({
    code: yup.string().required("លេខកូដផលិតផលគឺចាំបាច់"),
    name: yup.string().required("ឈ្មោះផលិតផលគឺចាំបាច់"),
    quantity: yup.number()
        .required("ចំនួនផលិតផលគឺចាំបាច់")
        .min(1, "ចំនួនត្រូវតែធំជាង 0"),
    price: yup.number()
        .required("តម្លៃផលិតផលគឺចាំបាច់")
        .min(0, "តម្លៃត្រូវតែធំជាង ឬស្មើ 0"),
    description: yup.string()
        .required("ការពិពណ៌នាគឺចាំបាច់")
        .min(10, "ការពិពណ៌នាត្រូវតែមានយ៉ាងហោចណាស់ 10 តួអក្សរ"),
    images: yup.array()
        .max(5, "រូបភាពអតិបរមា 5 រូប")
});
