<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "investigation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_type
 * @property integer $status
 * @property string $job
 * @property integer $income
 * @property string $reason_none
 * @property integer $vip
 * @property string $like
 * @property string $say
 * @property string $reason_first
 * @property string $ext1
 * @property string $ext2
 * @property string $ext3
 * @property string $ext4
 * @property string $ext5
 */
class Investigation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'investigation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'user_type', 'status', 'income', 'vip'], 'integer'],
            [['job', 'reason_none', 'like', 'reason_first', 'ext1', 'ext2', 'ext3','ext4','ext5'], 'string', 'max' => 255],
            [['say'], 'string', 'max' => 2000],
            [['user_id'], 'unique', 'targetAttribute' => ['user_id'], 'message' => '不能重复提交反馈']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_type' => 'User Type',
            'status' => '1 学生 2 毕业啦',
            'job' => '那你现在做什么呀',
            'income' => '1 3000以下 2 3000-5000 3 5000-8000 4 8000-10000 5 10000-15000 6 15000-20000 7 20000以上',
            'reason_none' => '1 周末太忙啦，没有时间线下参与 2 其实周末也不忙，就是懒得不愿意出家门 3 我对Someet平台这类青年人基于兴趣的自发活动平台不感兴趣 4 我对Someet平台这类青年自发活动很认可，但是没看到喜欢的活动内容 5 关注后一直想参加，但是不知道如何操作去参与到活动中 6 有很多活动看起来不错，但是我不知道是具体做什么的 7 我生活的城市，没有Someet活动可以参与',
            'vip' => '1 普通会员：59元／3个月无限次报名 2 高级会员：99元／半年无限次报名 3 超级会员：239元／半年无限次报名＋超值周边大礼包 4 钻石会员：999元／全年无限次报名＋专属钻石会员活动＋新活动首发体验＋超值周边大礼包＋用户聚会＋周年趴门票＋3次邀请好友参加活动机会 5 以上我都不想选择',
            'like' => '1 有同类兴趣或经历的小伙伴聚在一起玩的活动，例如聊仙剑，烟草交流会 2 让人打开心扉深度畅聊的活动，例如黑暗中的对话、假想葬礼、孤单小酒馆 3 脑洞大开的活动，例如黑暗饮料品鉴、地铁大笑行为艺术 4 提升审美品位和生活品质，尝试新技能和新体验的活动，例如：学习红酒品鉴、打泰拳、做烘焙、海纳纹身 5 可以给自己带来成长、增加社会竞争力的活动，例如读书分享、行业交流等 6 一起探索城市优质消费内容的活动，例如参加南锣戏剧节、去SM餐厅、看展等 7其他',
            'say' => '还有什么想告诉我们的',
            'reason_first' => '1 周末太忙啦，再没有时间线下参与 2 其实周末也不忙，就是懒得不愿意出家门 3 我对Someet平台这类青年人基于兴趣的自发活动不感兴趣 4 我对Someet平台这类青年自发活动很认可，但是再没看到喜欢的活动内容 5 有很多活动看起来不错，但是我不知道是具体是做什么的 6 第一次参加活动后，感觉体验不够好 7 我去外地生活了',
            'ext1' => '1 我从来都是独来独往，不喜欢跟别人一起玩儿。 2 活动里面的用户年龄都偏小，体验下来我觉得跟大家没什么好聊的。 3 我不喜欢这种陌生人在一起的场合，很多时候我都只跟熟人一起出去玩儿。 4 我有自己固定的兴趣圈子，圈内朋友经常在一起玩儿。比如岩友圈，骑行圈，狼人杀圈等。 5 我更喜欢参与更容易的周末消费内容，有空的时候我更多选择去吃好吃的，看电影、演出、话剧等。 6 我更喜欢哪怕收费多一点，但是组织者有相对较好的背景，更有品质保障的活动。比如手冲比赛冠军带你学手冲，电影制片人的观影活动等，木工品牌主理人的木工活动。 7 我更喜欢可以给我带来实质成长的活动，比如大师讲座，行业交流，学习课程等。',
            'ext2' => 'Someet对你来说意味着什么',
            'ext3' => '喜欢的活动的填充',
            'ext4' => '没选择收费套餐的原因',
            'ext5' => '扩展5',
        ];
    }
}
