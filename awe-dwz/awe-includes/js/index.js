/**
  扩展一个index模块
**/      
 
layui.define(function(exports){ //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  
    layui.use('element', function(){
        var element = layui.element;
        
        //…
    });

    layui.use('form', function(){
      var form = layui.form;
      
      // //监听提交
      // form.on('submit(formDemo)', function(data){
      //   layer.msg(JSON.stringify(data.field));
      //   return false;
      // });
    });

    layui.use(['jquery', 'layer'], function(){ 
      var $ = layui.$ //重点处
      ,layer = layui.layer;
      
      //后面就跟你平时使用jQuery一样
      $('.awe-dwz-add').click(function() {
        document.aweForm.action = "index.php?action=add";
        document.aweForm.submit();
      });

      $('.awe-dwz-fresh').click(function() {
        document.aweForm.action = "index.php?action=fresh";
        document.aweForm.submit();
      });
    });
    
    //输出test接口
    exports('index');
});   