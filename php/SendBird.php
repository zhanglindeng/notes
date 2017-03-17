<?php

namespace Sendbird;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * todo 不要使用array作为参数，定义基类来确定参数，返回值也不要直接返回API的数据，解析后再返回
 * todo test open channel methods
 * Class Sendbird
 * @package Sendbird
 */
class Sendbird
{
    /**
     * @var string
     */
    private $apiToken;

    /**
     * @var Sendbird
     */
    private static $instance;


    /**
     * @param $channel_url string
     * @param array $user_ids
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelMessageUnreadCount($channel_url, array $user_ids)
    {
        if (empty($user_ids)) {
            throw new Exception('empty user_ids array');
        }

        $url = 'group_channels/{channel_url}/messages/unread_count';
        $url = $this->buildUrl($url, [
            'channel_url' => $channel_url,
        ]);

        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        $url .= '?user_ids=' . implode(',', $user_ids);

        return $this->get($url);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @return bool|int
     */
    public function openChannelMessageTotalCount($channel_url)
    {
        return $this->messageTotalCount('open_channels', $channel_url);
    }

    /**
     * @param $channel_url string
     * @return bool|mixed
     */
    public function groupChannelMessageTotalCount($channel_url)
    {
        return $this->messageTotalCount('group_channels', $channel_url);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $user_id string
     * @return bool|mixed
     */
    public function openChannelMessageMarkRead($channel_url, $user_id)
    {
        return $this->messageMarkRead('open_channels', $channel_url, $user_id);
    }

    /**
     * @param $channel_url string
     * @param $user_id string
     * @return bool|mixed
     */
    public function groupChannelMessageMarkRead($channel_url, $user_id)
    {
        return $this->messageMarkRead('group_channels', $channel_url, $user_id);
    }

    /**
     * @param $channel_url
     * @param $message_id
     * @return bool|mixed
     */
    public function groupChannelMessageDelete($channel_url, $message_id)
    {
        return $this->messageDelete('group_channels', $channel_url, $message_id);
    }

    /**
     * notice no test
     * @param $channel_url
     * @param $message_id
     * @return bool|mixed
     */
    public function openChannelMessageDelete($channel_url, $message_id)
    {
        return $this->messageDelete('open_channels', $channel_url, $message_id);
    }

    /**
     * @param $channel_url string
     * @param $message_id string
     * @return bool|mixed
     */
    public function groupChannelMessageView($channel_url, $message_id)
    {
        return $this->messageView('group_channels', $channel_url, $message_id);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $message_id string
     * @return bool|mixed
     */
    public function openChannelMessageView($channel_url, $message_id)
    {
        return $this->messageView('open_channels', $channel_url, $message_id);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $message_ts integer
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelAdminMessageList($channel_url, $message_ts, array $params = [])
    {
        $params['message_type'] = 'ADMM';

        return $this->groupChannelMessageList($channel_url, $message_ts, $params);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $message_ts integer
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelFileMessageList($channel_url, $message_ts, array $params = [])
    {
        $params['message_type'] = 'FILE';

        return $this->groupChannelMessageList($channel_url, $message_ts, $params);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $message_ts integer
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelTextMessageList($channel_url, $message_ts, array $params = [])
    {
        $params['message_type'] = 'MESG';

        return $this->groupChannelMessageList($channel_url, $message_ts, $params);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $message_ts int
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelMessageList($channel_url, $message_ts, array $params = [])
    {
        return $this->messageList('group_channels', $channel_url, $message_ts, $params);
    }

    /**
     * notice no test
     * @param $channel_url string
     * @param $message_ts int
     * @param array $params
     * @return bool|mixed
     */
    public function openChannelMessageList($channel_url, $message_ts, array $params = [])
    {
        return $this->messageList('open_channels', $channel_url, $message_ts, $params);
    }

    /**
     * $optionsFields = [
     * 'custom_type',
     * 'data',
     * 'is_silent',
     * ];
     * @param $channel_url string
     * @param $message string
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelAdminMessageSend($channel_url, $message, array $params = [])
    {
        $params = array_merge($params, [
            'message' => $message,
        ]);

        // TEST MESSAGE : You can not modify this message on Free Plan
        // v_v 55555...
        return $this->messageSend('admin', 'group_channels', $channel_url, $params);
    }

    /**
     * $optionsFields = [
     * 'file_name',
     * 'file_size',
     * 'file_type',
     * 'custom_type',
     * 'custom_field',
     * 'mark_as_read',
     * ];
     * @param $channel_url string
     * @param $sender_user_id string
     * @param $file_url string
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelFileMessageSend($channel_url, $sender_user_id, $file_url, array $params = [])
    {
        $params = array_merge($params, [
            'user_id' => $sender_user_id,
            'url'     => $file_url,
        ]);

        return $this->messageSend('file', 'group_channels', $channel_url, $params);
    }

    /**
     * $optionsFields = [
     * 'custom_type',
     * 'data',
     * 'mark_as_read',
     * ];
     * @param $channel_url string
     * @param $sender_user_id string
     * @param $message string
     * @param array $params
     * @return bool|mixed
     */
    public function groupChannelTextMessageSend($channel_url, $sender_user_id, $message, array $params = [])
    {
        $params = array_merge($params, [
            'user_id' => $sender_user_id,
            'message' => $message,
        ]);

        return $this->messageSend('text', 'group_channels', $channel_url, $params);
    }

    /**
     * @param $channel_url string
     * @param array $user_ids
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelLeave($channel_url, array $user_ids)
    {
        if (empty($user_ids)) {
            throw new Exception('empty user_ids array');
        }

        $url = 'group_channels/{channel_url}/leave';
        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->put($url, ['user_ids' => $user_ids]);
    }

    /**
     * 潜水模式吗？
     * @param $channel_url string
     * @param $user_id string
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelHide($channel_url, $user_id)
    {
        $url = 'group_channels/{channel_url}/hide';
        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->put($url, ['user_id' => $user_id]);
    }

    /**
     * @param $channel_url string
     * @param array $user_ids
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelInviteMember($channel_url, array $user_ids)
    {
        if (empty($user_ids)) {
            throw new Exception('empty user_ids array');
        }

        $url = 'group_channels/{channel_url}/invite';
        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->post($url, ['user_ids' => $user_ids]);
    }

    /**
     * @param $channel_url string
     * @param $user_id string
     * @return bool
     * @throws Exception
     */
    public function groupChannelCheckIfMember($channel_url, $user_id)
    {
        $url = 'group_channels/{channel_url}/members/{user_id}';
        $url = $this->buildUrl($url, ['channel_url' => $channel_url, 'user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url or user_id');
        }
        $res = $this->get($url);

        if (is_object($res)) {
            return $res->is_member;
        }

        return false;
    }

    /**
     * @param $channel_url string
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelMemberList($channel_url, array $params = [])
    {
        $url = 'group_channels/{channel_url}/members';

        if (!empty($params)) {
            if (!$this->isAssoc($params)) {
                throw new Exception('The params must be assoc array');
            }

            $keys = array_keys($params);

            $fields = [
                'token',
                'limit',
            ];

            $res = $this->invalidField($keys, $fields);
            if ($res !== false) {
                throw new Exception($res);
            }

            $url .= '?' . $this->buildQueryString($params);
        }

        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->get($url);
    }

    /**
     * @param $channel_url string
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelDelete($channel_url)
    {
        $url = 'group_channels/{channel_url}';
        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->delete($url);
    }

    /**
     * $fields = [
     * 'show_read_receipt',
     * 'show_member',
     * ];
     * @param $channel_url string
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelView($channel_url, array $params = [])
    {
        $url = 'group_channels/{channel_url}';
        if (!empty($params)) {

            if (!$this->isAssoc($params)) {
                throw new Exception('The params must be assoc array');
            }

            $fields = [
                'show_read_receipt',
                'show_member',
            ];

            $keys = array_keys($params);

            $res = $this->invalidField($keys, $fields);
            if ($res !== false) {
                throw new Exception($res);
            }

            $url .= '?' . $this->buildQueryString($params);
        }


        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->get($url);
    }

    /**
     * $fields = [
     * 'name',
     * 'cover_url',
     * 'custom_type',
     * 'data',
     * 'is_distinct',
     * ];
     * @param $channel_url string
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelUpdate($channel_url, array $params)
    {
        $fields = [
            'name',
            'cover_url',
            'custom_type',
            'data',
            'is_distinct',
        ];

        $keys = array_keys($params);
        $res = $this->invalidField($keys, $fields);
        if ($res !== false) {
            throw new Exception($res);
        }

        // name
        if (in_array('name', $keys)) {
            if (strlen($params['name']) > 1024) {
                throw new Exception('The name maximum length is 1024 bytes');
            }
        }

        // cover_url
        if (in_array('cover_url', $keys)) {
            if (strlen($params['cover_url']) > 2048) {
                throw new Exception('The cover_url maximum length is 2048 bytes');
            }
        }

        // custom_type
        if (in_array('custom_type', $keys)) {
            if (strlen($params['custom_type']) > 128) {
                throw new Exception('The custom_type maximum length is 128 bytes');
            }
        }

        $url = 'group_channels/{channel_url}';
        $url = $this->buildUrl($url, ['channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_url');
        }

        return $this->put($url, $params);
    }

    /**
     * $fields = [
     * 'token',
     * 'limit',
     * 'show_member',
     * 'show_read_receipt',
     * 'distinct_mode',
     * 'members_exactly_in',
     * 'members_include_in',
     * 'members_nickname_contains',
     * 'query_type',
     * 'custom_type',
     * 'channel_urls',
     * ];
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelList(array $params = [])
    {
        $fields = [
            'token',
            'limit',
            'show_member',
            'show_read_receipt',
            'distinct_mode',
            'members_exactly_in',
            'members_include_in',
            'members_nickname_contains',
            'query_type',
            'custom_type',
            'channel_urls',
        ];

        $url = 'group_channels';
        if (!empty($params)) {

            $keys = array_keys($params);

            $res = $this->invalidField($keys, $fields);
            if ($res !== false) {
                throw new Exception($res);
            }

            // members_exactly_in
            if (in_array('members_exactly_in', $keys)) {
                $tempArr = explode(',', $params['members_exactly_in']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);
                $params['members_exactly_in'] = implode(',', $url_encode_ids);
            }

            // members_include_in
            if (in_array('members_include_in', $keys)) {
                $tempArr = explode(',', $params['members_include_in']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);
                $params['members_include_in'] = implode(',', $url_encode_ids);
            }

            // members_nickname_contains
            if (in_array('members_nickname_contains', $keys)) {
                $tempArr = explode(',', $params['members_nickname_contains']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);
                $params['members_nickname_contains'] = implode(',', $url_encode_ids);
            }

            // channel_urls
            if (in_array('channel_urls', $keys)) {
                $tempArr = explode(',', $params['channel_urls']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);
                $params['channel_urls'] = implode(',', $url_encode_ids);
            }

            $url .= '?' . $this->buildQueryString($params);
        }

        return $this->get($url);
    }

    /**
     * $fields = [
     * 'name',
     * 'cover_url',
     * 'custom_type',
     * 'data',
     * 'user_ids',
     * 'is_distinct',
     * ];
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function groupChannelCreate(array $params)
    {
        if (empty($params) || !$this->isAssoc($params)) {
            throw new Exception('Invalid params');
        }

        $fields = [
            'name',
            'cover_url',
            'custom_type',
            'data',
            'user_ids',
            'is_distinct',
        ];

        $keys = array_keys($params);
        $res = $this->invalidField($keys, $fields);
        if ($res !== false) {
            throw new Exception($res);
        }

        // name
        if (in_array('name', $keys)) {
            if (strlen($params['name']) > 1024) {
                throw new Exception('The name maximum length is 1024 bytes');
            }
        }

        // cover_url
        if (in_array('cover_url', $keys)) {
            if (strlen($params['cover_url']) > 2048) {
                throw new Exception('The cover_url maximum length is 2048 bytes');
            }
        }

        // custom_type
        if (in_array('custom_type', $keys)) {
            if (strlen($params['custom_type']) > 128) {
                throw new Exception('The custom_type maximum length is 128 bytes');
            }
        }

        // user_ids 字符串传递过来，英文逗号(,)分割，再转成数组
        if (in_array('user_ids', $keys)) {
            // 仅可以是 activated 的用户
            $params['user_ids'] = explode(',', $params['user_ids']);
        }

        // is_distinct
        if (in_array('is_distinct', $keys)) {
            $params['is_distinct'] = (bool)$params['is_distinct'];
        }

        $url = 'group_channels';

        return $this->post($url, $params);
    }

    /**
     * notice no test
     * $fields = [
     * 'token',
     * 'limit',
     * 'show_empty',
     * 'show_member',
     * 'show_read_receipt',
     * 'distinct_mode',
     * 'order',
     * 'members_exactly_in',
     * 'members_nickname_contains',
     * 'members_include_in',
     * 'query_type',
     * 'custom_type',
     * 'channel_urls',
     * ];
     * @param $user_id string
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function userGroupChannelList($user_id, array $params = [])
    {
        $this->checkUserId($user_id);
        $url = 'users/{user_id}/my_group_channels';
        $url = $this->buildUrl($url, ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        if (!empty($params)) {

            if (!$this->isAssoc($params)) {
                throw new Exception('params must be assoc array');
            }

            $fields = [
                'token',
                'limit',
                'show_empty',
                'show_member',
                'show_read_receipt',
                'distinct_mode',
                'order',
                'members_exactly_in',
                'members_nickname_contains',
                'members_include_in',
                'query_type',
                'custom_type',
                'channel_urls',
            ];

            $keys = array_keys($params);

            $res = $this->invalidField($keys, $fields);
            if ($res !== false) {
                throw new Exception($res);
            }

            // members_exactly_in
            if (in_array('members_exactly_in', $keys)) {
                $tempArr = explode(',', $params['members_exactly_in']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);

                $params['members_exactly_in'] = implode(',', $url_encode_ids);
            }

            // members_nickname_contains
            if (in_array('members_nickname_contains', $keys)) {
                $tempArr = explode(',', $params['members_nickname_contains']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);

                $params['members_nickname_contains'] = implode(',', $url_encode_ids);
            }

            // members_include_in
            if (in_array('members_include_in', $keys)) {
                $tempArr = explode(',', $params['members_include_in']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);

                $params['members_include_in'] = implode(',', $url_encode_ids);
            }

            // channel_urls
            if (in_array('channel_urls', $keys)) {
                $tempArr = explode(',', $params['channel_urls']);
                $url_encode_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $tempArr);

                $params['channel_urls'] = implode(',', $url_encode_ids);
            }

            $url .= '?' . $this->buildQueryString($params);
        }

        return $this->get($url);
    }

    /**
     * @param $user_id string
     * @return bool|mixed
     * @throws Exception
     */
    public function userMarkAllMessageRead($user_id)
    {
        $this->checkUserId($user_id);

        $url = 'users/{user_id}/mark_as_read_all';
        $url = $this->buildUrl($url, ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        return $this->put($url, []);
    }

    /**
     * 用户（user_id）把谁(target_id)移除黑名单
     * @param $user_id string
     * @param $target_id string
     * @return bool|mixed
     * @throws Exception
     */
    public function userUnBlock($user_id, $target_id)
    {
        $this->checkUserId($user_id);

        if (!is_string($target_id)) {
            throw new Exception('Invalid target_id');
        }

        $url = 'users/{user_id}/block/{target_id}';
        $url = $this->buildUrl($url, ['user_id' => $user_id, 'target_id' => $target_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id or target_id');
        }

        return $this->delete($url);
    }

    /**
     * 获取用户(user_id)的黑名单列表
     * @param $user_id string
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function userBlockList($user_id, array $params = [])
    {
        $fields = ['token', 'limit'];

        $url = 'users/{user_id}/block';
        $url = $this->buildUrl($url, ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        if (!empty($params)) {
            $keys = array_keys($params);
            $res = $this->invalidField($keys, $fields);
            if ($res !== false) {
                throw new Exception($res);
            }

            $url .= '?' . $this->buildQueryString($params);
        }

        return $this->get($url);
    }

    /**
     * 用户（user_id）把谁（target_id）加入到黑名单
     * @param $user_id string
     * @param $target_id string
     * @return bool|mixed
     * @throws Exception
     */
    public function userBlock($user_id, $target_id)
    {
        $this->checkUserId($user_id);
        if (!is_string($target_id)) {
            throw new Exception('Invalid target_id');
        }

        $url = 'users/{user_id}/block';
        $url = $this->buildUrl($url, ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        return $this->post($url, ['target_id' => $target_id]);
    }

    /**
     * @param $user_id string
     * @return bool|int
     * @throws Exception
     */
    public function userUnreadMessageCount($user_id)
    {
        $this->checkUserId($user_id);

        $url = $this->buildUrl('users/{user_id}/unread_count', ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        $result = $this->get($url);
        if (is_object($result)) {
            return $result->unread_count;
        }

        return false;
    }

    /**
     * @param $user_id string
     * @return bool|mixed
     * @throws Exception
     */
    public function userDelete($user_id)
    {
        $this->checkUserId($user_id);

        $url = $this->buildUrl('users/{user_id}', ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        return $this->delete($url);
    }

    /**
     * @param $user_id string
     * @return bool|mixed
     * @throws Exception
     */
    public function userView($user_id)
    {
        $this->checkUserId($user_id);

        $url = $this->buildUrl('users/{user_id}', ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        return $this->get($url);
    }

    /**
     * $fields = [
     * 'nickname',
     * 'profile_url',
     * 'issue_access_token',
     * 'is_active',
     * 'leave_all_when_deactivated',
     * ];
     * @param $user_id string
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function userUpdate($user_id, array $params)
    {
        $fields = [
            'nickname',
            'profile_url',
            'issue_access_token',
            'is_active',
            'leave_all_when_deactivated',
        ];

        if (empty($params)) {
            throw new Exception('Invalid params');
        }

        $keys = array_keys($params);

        $res = $this->invalidField($keys, $fields);
        if ($res !== false) {
            throw new Exception($res);
        }

        if (in_array('nickname', $keys)) {
            $params['nickname'] = trim($params['nickname']);

            if (empty($params['nickname'])) {
                throw new Exception('empty nickname');
            }

            if (strlen($params['nickname']) > 80) {
                throw new Exception('nickname too long');
            }
        }

        if (in_array('profile_url', $keys)) {
            $params['profile_url'] = trim($params['profile_url']);

            if (empty($params['profile_url'])) {
                throw new Exception('empty profile_url');
            }

            if (strlen($params['profile_url']) > 2048) {
                throw new Exception('profile_url too long');
            }
        }

        $url = $this->buildUrl('users/{user_id}', ['user_id' => $user_id]);
        if (!is_string($url)) {
            throw new Exception('Invalid user_id');
        }

        return $this->put($url, $params);
    }

    /**
     * $fields = [
     * 'token',
     * 'limit',
     * 'active_mode',
     * 'show_bot',
     * 'user_ids',
     * ];
     * @param array $params
     * @return bool|mixed
     * @throws Exception
     */
    public function userList(array $params = [])
    {
        $fields = [
            'token',
            'limit',
            'active_mode',
            'show_bot',
            'user_ids',
        ];

        $url = 'users';
        if (!empty($params)) {

            $keys = array_keys($params);

            if (($res = $this->invalidField($keys, $fields)) !== false) {
                throw new Exception($res);
            }

            $flag = false;
            // user_ids 要单独处理, url_encode(,)
            if (in_array('user_ids', $keys)) {
                $user_ids = explode(',', trim(trim($params['user_ids']), ','));
                $user_ids = array_map(function ($v) {
                    return urlencode($v);
                }, $user_ids);

                unset($params['user_ids']);
                $flag = true;
                $url .= '?user_ids=' . implode(',', $user_ids);
            }

            if ($flag) {
                $url .= '&' . $this->buildQueryString($params);
            } else {
                $url .= '?' . $this->buildQueryString($params);
            }
        }

        return $this->get($url);
    }

    /**
     * $fields = [
     * 'user_id',
     * 'nickname',
     * 'profile_url',
     * 'issue_access_token',
     * ];
     * @param array $params
     * @return bool|object
     */
    public function userCreate(array $params)
    {
        $fields = [
            'user_id',
            'nickname',
            'profile_url',
            'issue_access_token',
        ];

        $this->checkParams($params, $fields);

        $url = 'users';
        $result = $this->post($url, $params);

        return $result ?: false;
    }

    /**
     * @param $apiToken string
     * @return Sendbird
     */
    public static function getInstance($apiToken)
    {
        if (empty(static::$instance)) {
            static::$instance = new static($apiToken);
        }

        return static::$instance;
    }

    // ========================================================================

    private function messageTotalCount($channel_type, $channel_url)
    {
        if (!in_array($channel_type, ['open_channels', 'group_channels'])) {
            throw new Exception('Invalid channel_type, can only open_channels or group_channels');
        }

        $url = '{channel_type}/{channel_url}/messages/total_count';
        $url = $this->buildUrl($url, [
            'channel_type' => $channel_type,
            'channel_url'  => $channel_url,
        ]);

        if (!is_string($url)) {
            throw new Exception('Invalid channel_type or channel_url');
        }

        $res = $this->get($url);
        if (is_object($res)) {
            return (int)$res->total;
        }

        return false;
    }

    private function messageMarkRead($channel_type, $channel_url, $user_id)
    {
        if (!in_array($channel_type, ['open_channels', 'group_channels'])) {
            throw new Exception('Invalid channel_type, can only open_channels or group_channels');
        }

        $url = '{channel_type}/{channel_url}/messages/mark_as_read';
        $url = $this->buildUrl($url, [
            'channel_type' => $channel_type,
            'channel_url'  => $channel_url,
        ]);

        if (!is_string($url)) {
            throw new Exception('Invalid channel_type or channel_url');
        }

        return $this->put($url, ['user_id' => $user_id]);
    }

    private function messageDelete($channel_type, $channel_url, $message_id)
    {
        if (!in_array($channel_type, ['open_channels', 'group_channels'])) {
            throw new Exception('Invalid channel_type, can only open_channels or group_channels');
        }

        $url = '{channel_type}/{channel_url}/messages/{message_id}';
        $url = $this->buildUrl($url, [
            'channel_type' => $channel_type,
            'channel_url'  => $channel_url,
            'message_id'   => $message_id,
        ]);

        if (!is_string($url)) {
            throw new Exception('Invalid channel_type or channel_url or message_id');
        }

        return $this->delete($url);
    }

    private function messageView($channel_type, $channel_url, $message_id)
    {
        if (!in_array($channel_type, ['open_channels', 'group_channels'])) {
            throw new Exception('Invalid channel_type, can only open_channels or group_channels');
        }

        $url = '{channel_type}/{channel_url}/messages/{message_id}';
        $url = $this->buildUrl($url, [
            'channel_type' => $channel_type,
            'channel_url'  => $channel_url,
            'message_id'   => $message_id,
        ]);

        if (!is_string($url)) {
            throw new Exception('Invalid channel_type or channel_url or message_id');
        }

        return $this->get($url);
    }

    private function messageList($channel_type, $channel_url, $message_ts, array $params = [])
    {
        if (!in_array($channel_type, ['open_channels', 'group_channels'])) {
            throw new Exception('Invalid channel_type, can only open_channels or group_channels');
        }

        $url = '{channel_type}/{channel_url}/messages?message_ts={message_ts}';
        $url = $this->buildUrl($url, [
            'channel_type' => $channel_type,
            'channel_url'  => $channel_url,
            'message_ts'   => $message_ts,
        ]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_type or channel_url or message_ts');
        }

        if (!empty($params)) {

            if (!$this->isAssoc($params)) {
                throw new Exception('The params must be assoc array');
            }

            $keys = array_keys($params);

            $fields = [
                'prev_limit',
                'next_limit',
                'include',
                'reverse',
                'custom_type',
                'message_type',
                'sender_id',
            ];

            $res = $this->invalidField($keys, $fields);
            if ($res !== false) {
                throw new Exception($res);
            }

            if (in_array('message_type', $keys)) {
                if (!in_array($params['message_type'], ['MESG', 'FILE', 'ADMM'])) {
                    throw new Exception('Invalid channel_type, can only MESG, FILE or ADMM');
                }
            }
        }

        return $this->get($url);
    }

    private function messageSend($message_type, $channel_type, $channel_url, array $params)
    {
        if (!in_array($message_type, ['text', 'file', 'admin'])) {
            throw new Exception('Invalid message_type, can only text, file or admin');
        }

        if (!in_array($channel_type, ['open_channels', 'group_channels'])) {
            throw new Exception('Invalid channel_type, can only open_channels or group_channels');
        }

        switch ($message_type) {
            case 'text':
                $params['message_type'] = 'MESG';
                $requiredFields = [
                    'message_type',
                    'user_id',
                    'message',
                ];
                $optionsFields = [
                    'custom_type',
                    'data',
                    'mark_as_read',
                ];
                break;
            case 'file':
                $params['message_type'] = 'FILE';
                $requiredFields = [
                    'message_type',
                    'user_id',
                    'url',
                ];
                $optionsFields = [
                    'file_name',
                    'file_size',
                    'file_type',
                    'custom_type',
                    'custom_field',
                    'mark_as_read',
                ];
                break;
            case 'admin':
                $params['message_type'] = 'ADMM';
                $requiredFields = [
                    'message_type',
                    'message',
                ];
                $optionsFields = [
                    'custom_type',
                    'data',
                    'is_silent',
                ];
                break;
            default:
                throw new Exception('Invalid channel_type, can only text, file or admin');
        }

        // custom_type
        if (isset($params['custom_type'])) {
            if (strlen($params['custom_type']) > 128) {
                throw new Exception(' The custom_type maximum length is 128 bytes');
            }
        }

        $keys = array_keys($params);
        $res = $this->missField($keys, $requiredFields);
        if ($res !== false) {
            throw new Exception($res);
        }

        $res = $this->invalidField($keys, array_merge($requiredFields, $optionsFields));
        if ($res !== false) {
            throw new Exception($res);
        }

        $url = '{channel_type}/{channel_url}/messages';
        $url = $this->buildUrl($url, ['channel_type' => $channel_type, 'channel_url' => $channel_url]);
        if (!is_string($url)) {
            throw new Exception('Invalid channel_type or channel_url');
        }

        return $this->post($url, $params);
    }

    private function checkUserId($user_id)
    {
        if (!is_string($user_id)) {
            throw new Exception('Invalid user_id');
        }

        return true;
    }

    private function delete($url)
    {
        return $this->doRequest('delete', $url);
    }

    private function put($url, array $params)
    {
        return $this->doRequest('put', $url, $params);
    }

    private function get($url)
    {
        return $this->doRequest('get', $url);
    }

    private function __construct($apiToken)
    {
        if (!is_string($apiToken)) {
            throw new Exception('Invalid API token');
        }

        $this->apiToken = $apiToken;
    }

    private function __clone()
    {
        throw new Exception('Not allow clone');
    }

    private function buildQueryString(array $params)
    {
        if (!$this->isAssoc($params)) {
            throw new Exception('Invalid param: params');
        }

        $arr = [];
        foreach ($params as $k => $v) {
            if (is_bool($v)) {
                $arr[] = $v ? $k . '=true' : $k . '=false';
            } else {
                $arr[] = $k . '=' . urlencode($v);
            }
        }

        return implode('&', $arr);
    }

    private function buildUrl($str, array $params)
    {
        if (!is_string($str)) {
            throw new Exception('Invalid param: str');
        }

        if (!$this->isAssoc($params)) {
            throw new Exception('Invalid param: params');
        }

        $patterns = array_keys($params);
        foreach ($patterns as $index => $pattern) {
            $patterns[$index] = "/{{$pattern}}/";
        }

        $replacements = array_values($params);
        foreach ($replacements as $index => $replacement) {
            $replacements[$index] = urlencode($replacement);
        }

        return preg_replace($patterns, $replacements, $str);
    }

    private function post($url, array $params)
    {
        return $this->doRequest('post', $url, $params);
    }

    private function missField(array $keys, array $fields)
    {
        $result = array_diff($fields, $keys);
        if (empty($result)) {
            return false;
        }

        return 'missing keys: ' . implode(',', $result);
    }

    private function checkParams(array $params, array $fields)
    {
        if ($this->isAssoc($params)) {
            $keys = array_keys($params);

            $result = $this->invalidField($keys, $fields);
            if ($result !== false) {
                throw new Exception($result);
            }

            $result = $this->missField($keys, $fields);
            if ($result !== false) {
                throw new Exception($result);
            }

            return true;
        }

        throw new Exception('params must a assoc array');
    }

    private function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function invalidField(array $keys, array $fields)
    {
        $result = array_diff($keys, $fields);
        if (empty($result)) {
            return false;
        }

        return 'invalid keys: ' . implode(',', $result);
    }

    private function doRequest($method, $url, array $params = [])
    {
        $headers = [
            'Content-Type' => 'application/json, charset=utf8',
            'Api-Token'    => $this->apiToken,
        ];
        $client = new Client([
            'base_uri' => 'https://api.sendbird.com/v3/',
            'timeout'  => 30.0,
        ]);
        $options = [
            'headers' => $headers,
            'verify'  => __DIR__ . '/cacert.pem',
        ];

        if (!empty($params)) {
            $options['json'] = $params;
        }

        try {
            $response = $client->request($method, $url, $options);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            }

        } catch (RequestException $e) {
            $str = "\r\n" . 'error: ' . $e->getMessage();
            // echo 'request ' . Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $str .= "\r\n" . 'status code: ' . $e->getResponse()->getStatusCode();
                $body = json_decode($e->getResponse()->getBody());
                $str .= "\r\n" . 'response error message: ' . $body->message;
                $str .= "\r\n" . 'response error code: ' . $body->code;
            }
            file_put_contents('error.log', $str, FILE_APPEND | LOCK_EX);
        }

        return false;
    }


}
