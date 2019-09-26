//index.js
//获取应用实例

var api = require('../../api.js');
const app = getApp();

// Page({
//   data: {
//     motto: 'Hello World',
//     userInfo: {},
//     hasUserInfo: false,
//     canIUse: wx.canIUse('button.open-type.getUserInfo'),
//     list:[
//       { text: "成为商家" }, { text: "我的好友" }, { text: "我的二维码" }, { text: "意见反馈" }, { text: "系统设置" },
//     ]
//   },
//   //事件处理函数
//   bindViewTap: function() {
//     wx.navigateTo({
//       // url: '../logs/logs'
//     })
//   },
//   onLoad: function () {
//       var page = this;
//       page.setData({
//           store: wx.getStorageSync('store'),
//       });
//       var pages_user_user = wx.getStorageSync('pages_user_user');
//       if (pages_user_user) {
//           page.setData(pages_user_user);
//       }
//       app.request({
//           url: api.user.index,
//           success: function (res) {
//               if (res.code == 0) {
//                   page.setData(res.data);
//                   wx.setStorageSync('pages_user_user', res.data);
//                   wx.setStorageSync("share_setting", res.data.share_setting);
//                   wx.setStorageSync("user_info", res.data.user_info);
//               }
//           }
//       });
//   getUserInfo: function(e) {
//     console.log(e)
//     app.globalData.userInfo = e.detail.userInfo
//     this.setData({
//       userInfo: e.detail.userInfo,
//       hasUserInfo: true
//     })
//   }
// })

Page({

    /**
     * 页面的初始数据
     */
    data: {
        contact_tel: "",
        show_customer_service: 0,
        user_center_bg: "/images/img-user-bg.png",
        user_info:{},

        // motto: 'Hello World',
        // userInfo: {},
        // hasUserInfo: false,
        // canIUse: wx.canIUse('button.open-type.getUserInfo'),
        // list:[
        //     { text: "成为商家" }, { text: "我的好友" }, { text: "我的二维码" }, { text: "意见反馈" }, { text: "系统设置" },
        // ]
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        app.pageOnLoad(this);
    },

    loadData: function (options) {
        var page = this;
        page.setData({
            store: wx.getStorageSync('store'),
        });
        var pages_user_user = wx.getStorageSync('pages_user_user');
        if (pages_user_user) {
            page.setData(pages_user_user);
        }
        app.request({
            url: api.user.index,
            success: function (res) {
                if (res.code == 0) {
                    page.setData(res.data);
                    wx.setStorageSync('pages_user_user', res.data);
                    wx.setStorageSync("share_setting", res.data.share_setting);
                    wx.setStorageSync("user_info", res.data.user_info);
                }
            }
        });
    },

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function () {

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        app.pageOnShow(this);
        var page = this;
        page.loadData();
    },

    callTel: function (e) {
        var tel = e.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: tel, //仅为示例，并非真实的电话号码
        });
    },
    apply: function (e) {
        var page = this;
        var share_setting = wx.getStorageSync("share_setting");
        var user_info = wx.getStorageSync("user_info");
        if (share_setting.share_condition == 1) {
            wx.navigateTo({
                url: '/pages/add-share/index',
            })
        } else if (share_setting.share_condition == 0 || share_setting.share_condition == 2) {
            if (user_info.is_distributor == 0) {
                wx.showModal({
                    title: "申请成为分销商",
                    content: "是否申请？",
                    success: function (r) {
                        if (r.confirm) {
                            wx.showLoading({
                                title: "正在加载",
                                mask: true,
                            });
                            app.request({
                                url: api.share.join,
                                methods: "POST",
                                success: function (res) {
                                    if (res.code == 0) {
                                        if (share_setting.share_condition == 0) {
                                            user_info.is_distributor = 2;
                                            wx.navigateTo({
                                                url: '/pages/add-share/index',
                                            })
                                        } else {
                                            user_info.is_distributor = 1;
                                            wx.navigateTo({
                                                url: '/pages/share/index',
                                            })
                                        }
                                        wx.setStorageSync("user_info", user_info);
                                    }
                                },
                                complete: function () {
                                    wx.hideLoading();
                                }
                            });
                        }
                    },
                })
            } else {
                wx.navigateTo({
                    url: '/pages/add-share/index',
                })
            }
        }
    },
    verify: function (e) {
        wx.scanCode({
            onlyFromCamera: false,
            success: function (res) {
                console.log(res)
                wx.navigateTo({
                    url: '/' + res.path,
                })
            }, fail: function (e) {
                wx.showToast({
                    title: '失败'
                });
            }
        });
    },
    member: function () {
        wx.navigateTo({
            url: '/pages/member/member',
        })
    },
    integral: function () {
        wx.navigateTo({
            url: '/pages/recharge-integral/index',
        })
    },
    card: function () {
        wx.navigateTo({
            url: '/pages/card/card',
        })
    },
    //事件处理函数
    bindViewTap: function () {
        var user_info = wx.getStorageSync("user_info");
        if (user_info == ""){
            wx.navigateTo({
                url: '/pages/authorize/authorize',
            })
        }
    }
});
