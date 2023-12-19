import { Body, Controller, HttpCode, HttpStatus, Post } from '@nestjs/common';
import { UsersService } from './users.service';

@Controller('users')
export class UsersController {
  constructor(private userService: UsersService) {}

  // @HttpCode(HttpStatus.OK)
  // @Post('login')
  // // eslint-disable-next-line @typescript-eslint/no-unused-vars
  // findOne(@Body() id: Record<number, any>) {
  //   return this.userService.findOne(1);
  // }
  // @HttpCode(HttpStatus.OK)
  // @Post('registration')
  // createUser(@Body() ReqBody: Record<string, any>) {
  //   return this.userService.createUser(ReqBody);
  // }
}
