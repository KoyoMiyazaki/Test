from django.db import models
from django.core.validators import RegexValidator

class User(models.Model):
    """ユーザモデル"""

    name = models.CharField(verbose_name='name',
                            max_length=50)
    email = models.EmailField(verbose_name='email',
                              max_length=255,
                              validators=[RegexValidator(r'^[\w+\-.]+@[a-zA-Z\d\-.]+\.[a-zA-Z]+$', 'メールアドレスの形式ではない')])
    created_at = models.DateTimeField(verbose_name='created_at',
                                      auto_now_add=True)
    updated_at = models.DateTimeField(verbose_name='updated_at',
                                      auto_now=True)

    class Meta:
        verbose_name_plural = 'User'