from django.db import models

class User(models.Model):
    """日記モデル"""

    name = models.CharField(verbose_name='name', max_length=50)
    email = models.EmailField(verbose_name='email', max_length=50)
    created_at = models.DateTimeField(verbose_name='created_at', auto_now_add=True)
    updated_at = models.DateTimeField(verbose_name='updated_at', auto_now=True)

    class Meta:
        verbose_name_plural = 'User'