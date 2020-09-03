<?php

namespace App\Base\Http\Requests;

/**
 * Holds all available validation rules
 */
trait Rules
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $rules = [
        /**
                 * User
                 */
        // user/profile
        'name' => ['string', 'max:255'],
        'firstname' => ['string', 'max:255'],
        'lastname' => ['string', 'max:255'],
        'surname' => ['string', 'max:255'],
        'middlename' => ['string', 'max:255'],
        'othername' => ['string', 'max:255'],
        // 'name' => ['required_if:name_required,true', 'string', 'max:255'],
        // required
        // 'firstname' => ['required_if:firstname_required,true', 'string', 'max:255'],
        // 'name_required' => ['sometimes', 'boolean'],
        // 'lastname' => ['required_if:lastname_required,true', 'string', 'max:255'],
        // 'firstname_required' => ['sometimes', 'boolean'],
        // 'surname' => ['required_if:surname_required,true', 'string', 'max:255'],
        // 'lastname_required' => ['sometimes', 'boolean'],
        // 'middlename' => ['required_if:middlename_required,true', 'string', 'max:255'],
        // 'surname_required' => ['sometimes', 'boolean'],
        // 'othername' => ['required_if:othername_required,true', 'string', 'max:255'],
        // 'middlename_required' => ['sometimes', 'boolean'],
        // 'othername_required' => ['sometimes', 'boolean'],

        // email
        'email' => ['email', 'max:255'],
        'email1' => ['email', 'max:255'],
        'email2' => ['email', 'max:255'],
        'email3' => ['email', 'max:255'],
        // required
        // 'email_required' => ['sometimes', 'boolean'],
        // 'email' => ['required_if:email_required,true', 'email', 'max:255'],
        // 'email1_required' => ['sometimes', 'boolean'],
        // 'email1' => ['required_if:email1_required,true', 'email', 'max:255'],
        // 'email2_required' => ['sometimes', 'boolean'],
        // 'email2' => ['required_if:email2_required,true', 'email', 'max:255'],
        // 'email3_required' => ['sometimes', 'boolean'],
        // 'email3' => ['required_if:email3_required,true', 'email', 'max:255'],

        // mobile
        'mobile' => ['string', 'max:255'],
        'mobile1' => ['string', 'max:255'],
        'mobile2' => ['string', 'max:255'],
        'mobile3' => ['string', 'max:255'],
        // required
        // 'mobile_required' => ['sometimes', 'boolean'],
        // 'mobile' => ['required_if:mobile_required,true', 'string', 'max:255'],
        // 'mobile1_required' => ['sometimes', 'boolean'],
        // 'mobile1' => ['required_if:mobile1_required,true', 'string', 'max:255'],
        // 'mobile2_required' => ['sometimes', 'boolean'],
        // 'mobile2' => ['required_if:mobile2_required,true', 'string', 'max:255'],
        // 'mobile3_required' => ['sometimes', 'boolean'],
        // 'mobile3' => ['required_if:mobile3_required,true', 'string', 'max:255'],

        // cell
        'cell' => ['string', 'max:255'],
        'cell1' => ['string', 'max:255'],
        'cell2' => ['string', 'max:255'],
        'cell3' => ['string', 'max:255'],
        // required
        // 'image_required' => ['sometimes', 'boolean'],
        // 'cell' => ['required_if:cell_required,true', 'string', 'max:255'],
        // 'image1_required' => ['sometimes', 'boolean'],
        // 'cell1' => ['required_if:cell1_required,true', 'string', 'max:255'],
        // 'image2_required' => ['sometimes', 'boolean'],
        // 'cell2' => ['required_if:cell2_required,true', 'string', 'max:255'],
        // 'image3_required' => ['sometimes', 'boolean'],
        // 'cell3' => ['required_if:cell3_required,true', 'string', 'max:255'],

        // landline
        'landline' => ['string', 'max:255'],
        'landline1' => ['string', 'max:255'],
        'landline2' => ['string', 'max:255'],
        'landline3' => ['string', 'max:255'],
        // required
        // 'landline_required' => ['sometimes', 'boolean'],
        // 'landline' => ['required_if:landline_required,true', 'string', 'max:255'],
        // 'landline1_required' => ['sometimes', 'boolean'],
        // 'landline1' => ['required_if:landline1_required,true', 'string', 'max:255'],
        // 'landline2_required' => ['sometimes', 'boolean'],
        // 'landline2' => ['required_if:landline2_required,true', 'string', 'max:255'],
        // 'landline3_required' => ['sometimes', 'boolean'],
        // 'landline3' => ['required_if:landline3_required,true', 'string', 'max:255'],

        // address
        'address' => ['string', 'max:255'],
        'address1' => ['string', 'max:255'],
        // required
        // 'address_required' => ['sometimes', 'boolean'],
        // 'address1_required' => ['sometimes', 'boolean'],

        // 'address' => ['required_if:address_required,true', 'string', 'max:255'],
        // street
        // 'address1' => ['required_if:address1_required,true', 'string', 'max:255'],
        'street' => ['string', 'max:255'],
        'street1' => ['string', 'max:255'],
        // required
        // 'street_required' => ['sometimes', 'boolean'],
        // 'street1_required' => ['sometimes', 'boolean'],

        // 'street' => ['required_if:street_required,true', 'string', 'max:255'],
        // city
        // 'street1' => ['required_if:street1_required,true', 'string', 'max:255'],
        'city' => ['string', 'max:255'],
        'city1' => ['string', 'max:255'],
        // required
        // 'city_required' => ['sometimes', 'boolean'],
        // 'city1_required' => ['sometimes', 'boolean'],

        // 'city' => ['required_if:city_required,true', 'string', 'max:255'],
        // state
        // 'city1' => ['required_if:city1_required,true', 'string', 'max:255'],
        'state' => ['string', 'max:255'],
        'state1' => ['string', 'max:255'],
        // required
        // 'state_required' => ['sometimes', 'boolean'],
        // 'state1_required' => ['sometimes', 'boolean'],

        // 'state' => ['required_if:state_required,true', 'string', 'max:255'],
        // county
        // 'state1' => ['required_if:state1_required,true', 'string', 'max:255'],
        'county' => ['string', 'max:255'],
        'county1' => ['string', 'max:255'],
        // required
        // 'county_required' => ['sometimes', 'boolean'],
        // 'county1_required' => ['sometimes', 'boolean'],

        // 'county' => ['required_if:county_required,true', 'string', 'max:255'],
        // lga - Local Goverment Area
        // 'county1' => ['required_if:county1_required,true', 'string', 'max:255'],
        'lga' => ['string', 'max:255'],
        'lga1' => ['string', 'max:255'],
        // required
        // 'lga_required' => ['sometimes', 'boolean'],
        // 'lga1_required' => ['sometimes', 'boolean'],

        // 'lga' => ['required_if:lga_required,true', 'string', 'max:255'],
        // region
        // 'lga1' => ['required_if:lga1_required,true', 'string', 'max:255'],
        'region' => ['string', 'max:255'],
        'region1' => ['string', 'max:255'],
        // required
        // 'region_required' => ['sometimes', 'boolean'],
        // 'region1_required' => ['sometimes', 'boolean'],

        // 'region' => ['required_if:region_required,true', 'string', 'max:255'],
        // country
        // 'region1' => ['required_if:region1_required,true', 'string', 'max:255'],
        'country' => ['string', 'max:255'],
        'country1' => ['string', 'max:255'],
        // required
        // 'country_required' => ['sometimes', 'boolean'],
        // 'country1_required' => ['sometimes', 'boolean'],

        // 'country' => ['required_if:country_required,true', 'string', 'max:255'],
        // zip code
        // 'country1' => ['required_if:country1_required,true', 'string', 'max:255'],
        'zip_code' => ['string', 'max:50'],
        'zip_code1' => ['string', 'max:50'],
        // required
        // 'zip_code_required' => ['sometimes', 'boolean'],
        // 'zip_code1_required' => ['sometimes', 'boolean'],

        // 'zip_code' => ['required_if:zip_code_required,true', 'string', 'max:50'],
        // postal code
        // 'zip_code1' => ['required_if:zip_code1_required,true', 'string', 'max:50'],
        'postal_code' => ['string', 'max:50'],
        'postal_code1' => ['string', 'max:50'],
        // required
        // 'postal_code_required' => ['sometimes', 'boolean'],
        // 'postal_code1_required' => ['sometimes', 'boolean'],

        // 'postal_code' => ['required_if:postal_code_required,true', 'string', 'max:50'],

        // 'postal_code1' => ['required_if:postal_code1_required,true', 'string', 'max:50'],








        /**
                 * Image
                 */
        // image
        'image' => ['image'],
        'image1' => ['image'],
        'image2' => ['image'],
        'image3' => ['image'],
        // required
        // 'image_required' => ['sometimes', 'boolean'],
        // 'image' => ['required_if:image_required,true', 'image'],
        // 'image1_required' => ['sometimes', 'boolean'],
        // 'image1' => ['required_if:image1_required,true', 'image'],
        // 'image2_required' => ['sometimes', 'boolean'],
        // 'image2' => ['required_if:image2_required,true', 'image'],
        // 'image3_required' => ['sometimes', 'boolean'],
        // 'image3' => ['required_if:image3_required,true', 'image'],

        // cover image
        'cover_image' => ['image'],
        'cover_image1' => ['image'],
        'cover_image2' => ['image'],
        'cover_image3' => ['image'],
        // required
        // 'cover_image_required' => ['sometimes', 'boolean'],
        // 'cover_image' => ['required_if:cover_image_required,true', 'image'],
        // 'cover_image1_required' => ['sometimes', 'boolean'],
        // 'cover_image1' => ['required_if:cover_image1_required,true', 'image'],
        // 'cover_image2_required' => ['sometimes', 'boolean'],
        // 'cover_image2' => ['required_if:cover_image2_required,true', 'image'],
        // 'cover_image3_required' => ['sometimes', 'boolean'],
        // 'cover_image3' => ['required_if:cover_image3_required,true', 'image'],

        // profile image
        'profile_image' => ['image'],
        'profile_image1' => ['image'],
        'profile_image2' => ['image'],
        'profile_image3' => ['image'],
        // required
        // 'profile_image_required' => ['sometimes', 'boolean'],
        // 'profile_image' => ['required_if:profile_image_required,true', 'image'],
        // 'profile_image1_required' => ['sometimes', 'boolean'],
        // 'profile_image1' => ['required_if:profile_image1_required,true', 'image'],
        // 'profile_image2_required' => ['sometimes', 'boolean'],
        // 'profile_image2' => ['required_if:profile_image2_required,true', 'image'],
        // 'profile_image3_required' => ['sometimes', 'boolean'],
        // 'profile_image3' => ['required_if:profile_image3_required,true', 'image'],










        /**
                 * Product / material
                 */
        // product image
        'product_image' => ['image'],
        'product_image1' => ['image'],
        'product_image2' => ['image'],
        'product_image3' => ['image'],
        // required
        // 'product_image_required' => ['sometimes', 'boolean'],
        // 'product_image' => ['required_if:product_image_required,true', 'image'],
        // 'product_image1_required' => ['sometimes', 'boolean'],
        // 'product_image1' => ['required_if:product_image1_required,true', 'image'],
        // 'product_image2_required' => ['sometimes', 'boolean'],
        // 'product_image2' => ['required_if:product_image2_required,true', 'image'],
        // 'product_image3_required' => ['sometimes', 'boolean'],
        // 'product_image3' => ['required_if:product_image3_required,true', 'image'],

        // material image
        'material_image' => ['image'],
        'material_image1' => ['image'],
        'material_image2' => ['image'],
        'material_image3' => ['image'],
        // required
        // 'material_image_required' => ['sometimes', 'boolean'],
        // 'material_image' => ['required_if:material_image_required,true', 'image'],
        // 'material_image1_required' => ['sometimes', 'boolean'],
        // 'material_image1' => ['required_if:material_image1_required,true', 'image'],
        // 'material_image2_required' => ['sometimes', 'boolean'],
        // 'material_image2' => ['required_if:material_image2_required,true', 'image'],
        // 'material_image3_required' => ['sometimes', 'boolean'],
        // 'material_image3' => ['required_if:material_image3_required,true', 'image'],

        // price, discount and discounted price
        'price' => ['integer'],
        'price1' => ['integer'],
        'discount' => ['integer'],
        'discount1' => ['integer'],
        'discounted_price' => ['integer'],
        'discounted_price1' => ['integer'],
        // 'price' => ['required_if:price_required,true', 'integer'],
        // required
        // 'price1' => ['required_if:price1_required,true', 'integer'],
        // 'price_required' => ['sometimes', 'boolean'],
        // 'discount' => ['required_if:price_required,true', 'integer'],
        // 'price1_required' => ['sometimes', 'boolean'],
        // 'discount1' => ['required_if:price1_required,true', 'integer'],
        // 'discount_required' => ['sometimes', 'boolean'],
        // 'discounted_price' => ['required_if:discounted_price_required,true', 'integer'],
        // 'discount1_required' => ['sometimes', 'boolean'],
        // 'discounted_price1' => ['required_if:discounted_price1_required,true', 'integer'],
        // 'discounted_price_required' => ['sometimes', 'boolean'],
        // 'discounted_price1_required' => ['sometimes', 'boolean'],











        /**
                 * Description
                 */
                'description' => ['string'],
                'short_description' => ['string'],
        'long_description' => ['string'],
        'full_description' => ['string'],
        // required
        // 'description_required' => ['sometimes', 'boolean'],
        // 'description' => ['required_if:description_required,true', 'string'],
        // 'short_description_required' => ['sometimes', 'boolean'],
        // 'short_description' => ['required_if:short_description_required,true', 'string'],
        // 'long_description_required' => ['sometimes', 'boolean'],
        // 'long_description' => ['required_if:long_description_required,true', 'string'],
        // 'full_description_required' => ['sometimes', 'boolean'],
        // 'full_description' => ['required_if:full_description_required,true', 'string'],











        /**
         * file
         *
         *
         */
        // file
        'file' => ['file'],
        'file1' => ['file'],
        'file2' => ['file'],
        'file3' => ['file'],
        // required
        // 'file_required' => ['sometimes', 'boolean'],
        // 'file' => ['required_if:file_required,true', 'file'],
        // 'file1_required' => ['sometimes', 'boolean'],
        // 'file1' => ['required_if:file1_required,true', 'file'],
        // 'file2_required' => ['sometimes', 'boolean'],
        // 'file2' => ['required_if:file2_required,true', 'file'],
        // 'file3_required' => ['sometimes', 'boolean'],
        // 'file3' => ['required_if:file3_required,true', 'file'],











        /**
                 * Category
                 */
        // category_name
        'category_name' => ['string'],
        'category_name1' => ['string'],
        'category_name2' => ['string'],
        'category_name3' => ['string'],
        // required
        // 'category_name_required' => ['sometimes', 'boolean'],
        // 'category_name' => ['required_if:category_name_required,true', 'string'],
        // 'category_name1_required' => ['sometimes', 'boolean'],
        // 'category_name1' => ['required_if:category_name1_required,true', 'string'],
        // 'category_name2_required' => ['sometimes', 'boolean'],
        // 'category_name2' => ['required_if:category_name2_required,true', 'string'],
        // 'category_name3_required' => ['sometimes', 'boolean'],
        // 'category_name3' => ['required_if:category_name3_required,true', 'string'],

        // category_id
        'category_id' => ['integer'],
        'category_id1' => ['integer'],
        'category_id2' => ['integer'],
        'category_id3' => ['integer'],
        // required
        // 'category_id_required' => ['sometimes', 'boolean'],
        // 'category_id' => ['required_if:category_id_required,true', 'integer'],
        // 'category_id1_required' => ['sometimes', 'boolean'],
        // 'category_id1' => ['required_if:category_id1_required,true', 'integer'],
        // 'category_id2_required' => ['sometimes', 'boolean'],
        // 'category_id2' => ['required_if:category_id2_required,true', 'integer'],
        // 'category_id3_required' => ['sometimes', 'boolean'],
        // 'category_id3' => ['required_if:category_id3_required,true', 'integer'],













        /**
                 * messaging
                 */
        // message
        // message_name
        'message_name' => ['string'],
        'message_name1' => ['string'],
        'message_name2' => ['string'],
        'message_name3' => ['string'],
        // required
        // 'message_name_required' => ['sometimes', 'boolean'],
        // 'message_name' => ['required_if:message_name_required,true', 'string'],
        // 'message_name1_required' => ['sometimes', 'boolean'],
        // 'message_name1' => ['required_if:message_name1_required,true', 'string'],
        // 'message_name2_required' => ['sometimes', 'boolean'],
        // 'message_name2' => ['required_if:message_name2_required,true', 'string'],
        // 'message_name3_required' => ['sometimes', 'boolean'],
        // 'message_name3' => ['required_if:message_name3_required,true', 'string'],

        // message_id
        'message_id' => ['integer'],
        'message_id1' => ['integer'],
        'message_id2' => ['integer'],
        'message_id3' => ['integer'],
        // required
        // 'message_id_required' => ['sometimes', 'boolean'],
        // 'message_id' => ['required_if:message_id_required,true', 'integer'],
        // 'message_id1_required' => ['sometimes', 'boolean'],
        // 'message_id1' => ['required_if:message_id1_required,true', 'integer'],
        // 'message_id2_required' => ['sometimes', 'boolean'],
        // 'message_id2' => ['required_if:message_id2_required,true', 'integer'],
        // 'message_id3_required' => ['sometimes', 'boolean'],
        // 'message_id3' => ['required_if:message_id3_required,true', 'integer'],


        // sender
        // sender name
        'sender_name' => ['string'],
        'sender_name1' => ['string'],
        'sender_name2' => ['string'],
        'sender_name3' => ['string'],
        // required
        // 'sender_name_required' => ['sometimes', 'boolean'],
        // 'sender_name' => ['required_if:sender_name_required,true', 'string'],
        // 'sender_name1_required' => ['sometimes', 'boolean'],
        // 'sender_name1' => ['required_if:sender_name1_required,true', 'string'],
        // 'sender_name2_required' => ['sometimes', 'boolean'],
        // 'sender_name2' => ['required_if:sender_name2_required,true', 'string'],
        // 'sender_name3_required' => ['sometimes', 'boolean'],
        // 'sender_name3' => ['required_if:sender_name3_required,true', 'string'],

        // sender_id
        'sender_id' => ['integer'],
        'sender_id1' => ['integer'],
        'sender_id2' => ['integer'],
        'sender_id3' => ['integer'],
        // required
        // 'sender_id_required' => ['sometimes', 'boolean'],
        // 'sender_id' => ['required_if:sender_id_required,true', 'integer'],
        // 'sender_id1_required' => ['sometimes', 'boolean'],
        // 'sender_id1' => ['required_if:sender_id1_required,true', 'integer'],
        // 'sender_id2_required' => ['sometimes', 'boolean'],
        // 'sender_id2' => ['required_if:sender_id2_required,true', 'integer'],
        // 'sender_id3_required' => ['sometimes', 'boolean'],
        // 'sender_id3' => ['required_if:sender_id3_required,true', 'integer'],


        // receiver
        // receiver_name
        'receiver_name' => ['string'],
        'receiver_name1' => ['string'],
        'receiver_name2' => ['string'],
        'receiver_name3' => ['string'],
        // required
        // 'receiver_name_required' => ['sometimes', 'boolean'],
        // 'receiver_name' => ['required_if:receiver_name_required,true', 'string'],
        // 'receiver_name1_required' => ['sometimes', 'boolean'],
        // 'receiver_name1' => ['required_if:receiver_name1_required,true', 'string'],
        // 'receiver_name2_required' => ['sometimes', 'boolean'],
        // 'receiver_name2' => ['required_if:receiver_name2_required,true', 'string'],
        // 'receiver_name3_required' => ['sometimes', 'boolean'],
        // 'receiver_name3' => ['required_if:receiver_name3_required,true', 'string'],

        // receiver_id
        'receiver_id' => ['integer'],
        'receiver_id1' => ['integer'],
        'receiver_id2' => ['integer'],
        'receiver_id3' => ['integer'],
        // required
        // 'receiver_id_required' => ['sometimes', 'boolean'],
        // 'receiver_id' => ['required_if:receiver_id_required,true', 'integer'],
        // 'receiver_id1_required' => ['sometimes', 'boolean'],
        // 'receiver_id1' => ['required_if:receiver_id1_required,true', 'integer'],
        // 'receiver_id2_required' => ['sometimes', 'boolean'],
        // 'receiver_id2' => ['required_if:receiver_id2_required,true', 'integer'],
        // 'receiver_id3_required' => ['sometimes', 'boolean'],
        // 'receiver_id3' => ['required_if:receiver_id3_required,true', 'integer'],


        // thread
        // thread_name
        'thread_name' => ['string'],
        'thread_name1' => ['string'],
        'thread_name2' => ['string'],
        'thread_name3' => ['string'],
        // required
        // 'thread_name_required' => ['sometimes', 'boolean'],
        // 'thread_name' => ['required_if:thread_name_required,true', 'string'],
        // 'thread_name1_required' => ['sometimes', 'boolean'],
        // 'thread_name1' => ['required_if:thread_name1_required,true', 'string'],
        // 'thread_name2_required' => ['sometimes', 'boolean'],
        // 'thread_name2' => ['required_if:thread_name2_required,true', 'string'],
        // 'thread_name3_required' => ['sometimes', 'boolean'],
        // 'thread_name3' => ['required_if:thread_name3_required,true', 'string'],

        // thread_id
        'thread_id' => ['integer'],
        'thread_id1' => ['integer'],
        'thread_id2' => ['integer'],
        'thread_id3' => ['integer'],
        // required
        // 'thread_id_required' => ['sometimes', 'boolean'],
        // 'thread_id' => ['required_if:thread_id_required,true', 'integer'],
        // 'thread_id1_required' => ['sometimes', 'boolean'],
        // 'thread_id1' => ['required_if:thread_id1_required,true', 'integer'],
        // 'thread_id2_required' => ['sometimes', 'boolean'],
        // 'thread_id2' => ['required_if:thread_id2_required,true', 'integer'],
        // 'thread_id3_required' => ['sometimes', 'boolean'],
        // 'thread_id3' => ['required_if:thread_id3_required,true', 'integer'],


        // subject
        'subject' => ['string'],
        'subject1' => ['string'],
        // required
        // 'subject_required' => ['sometimes', 'boolean'],
        // 'subject1_required' => ['sometimes', 'boolean'],

        // 'subject' => ['required_if:subject_required,true', 'string'],

        // 'subject1' => ['required_if:subject1_required,true', 'string'],
        // body
        'body' => ['string'],
        'body1' => ['string'],
        // required
        // 'body_required' => ['sometimes', 'boolean'],
        // 'body1_required' => ['sometimes', 'boolean'],

        // 'body' => ['required_if:body_required,true', 'string'],
    ];
}
